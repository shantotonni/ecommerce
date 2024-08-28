<?php

namespace App\Model;

use App\Http\Controllers\CommonHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'Product';
    protected $primaryKey= 'ProductCode';
    public $timestamps = false;

    public function scopePermittedProject($query)
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        return $query->whereIn('ProjectID', $projectIds);
    }

    public function project() {
        return $this->belongsTo('App\Model\Project','ProjectID','ProjectID');
    }
    public function business() {
        return $this->belongsTo('App\Model\Business','Business','Business');
    }
    public function category() {
        return $this->belongsTo('App\Model\Category','CategoryId','CategoryId');
    }
    public function subcategory() {
        return $this->belongsTo('App\Model\SubCategory','SubCategoryId','SubCategoryId');
    }
    public function productImage() {
        return $this->hasMany('App\Model\ProductImage','ProductID','ProductCode');
    }

    public function stock(){
        return $this->hasOne('App\Model\Stock','ProductCode','ProductCode');
    }

    public function review() {
        return $this->hasMany('App\Model\ReviewRating','ProductId','ProductCode')->where('Approved',1)->take(5)->latest('CreatedAt');
    }

    public function reviews() {
        return $this->hasMany('App\Model\ReviewRating','ProductId','ProductCode')->latest('CreatedAt');
    }
    public function coupon() {
        return $this->hasMany('App\Model\Coupon','ProductID','ProductCode');
    }



    public function createSlug($title)
    {
        // Normalize the title
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = self::getRelatedSlugs($slug);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('ProductSlug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('ProductSlug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    public function getRelatedSlugs($slug)
    {
        return self::select('ProductSlug')->where('ProductSlug', 'like', $slug.'%')
            ->get();
    }

    public function scopePermitted($query)
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        return $query->whereIn('ProjectID', $projectIds);
    }
}
