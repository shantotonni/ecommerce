<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    protected $table = 'SubCategory';
    protected $primaryKey = 'SubCategoryId';
    public $timestamps = false;
    protected $guarded = ['SubCategoryId'];



    public function createSlug($title)
    {
        // Normalize the title
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = self::getRelatedSlugs($slug);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('SubcategorySlug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('SubcategorySlug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    public function getRelatedSlugs($slug)
    {
        return self::select('SubCategorySlug')->where('SubCategorySlug', 'like', $slug.'%')
            ->get();
    }
}
