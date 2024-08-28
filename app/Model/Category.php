<?php

namespace App\Model;

use App\Http\Controllers\CommonHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $table = 'Category';
    protected $primaryKey = 'CategoryId';
    public $timestamps = false;
    protected $guarded = ['CategoryId'];

    public function scopePermitted($query)
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        return $query->whereIn('ProjectID', $projectIds);
    }

    public function project() {
        return $this->belongsTo('\App\Model\Project','ProjectID','ProjectID');
    }

    public function createSlug($title)
    {
        // Normalize the title
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = self::getRelatedSlugs($slug);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('CategorySlug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('CategorySlug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    public function getRelatedSlugs($slug)
    {
        return self::select('CategorySlug')->where('CategorySlug', 'like', $slug.'%')
            ->get();
    }
}
