<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $table = 'Dealers';

    protected $primaryKey = 'DealerId';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    // The attributes that are mass assignable
    protected $fillable = [
        'Name',
        'Phone',
        'DistrictCode',
        'UpazillaCode',
        'Address',
        'Latitude',
        'Longitude',
        'ProductGroup',
        'CreatedAt',
        'UpdatedAt'
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'Latitude' => 'decimal:8',
        'Longitude' => 'decimal:8',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime',
    ];

    // Automatically set created_at and updated_at fields
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->CreatedAt = $model->freshTimestamp();
            $model->UpdatedAt = $model->freshTimestamp();
        });

        static::updating(function ($model) {
            $model->UpdatedAt = $model->freshTimestamp();
        });
    }

    public function district(){
        return $this->belongsTo('App\Model\District', 'DistrictCode','DistrictCode');
    }

    public function upazilla(){
        return $this->belongsTo('App\Model\Upazilla', 'UpazillaCode','UpazillaCode');
    }
}
