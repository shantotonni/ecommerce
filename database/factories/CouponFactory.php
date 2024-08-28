<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Model\Coupon::class, function (Faker $faker) {
    return [
        'ProjectId' => 3,
        'CouponCode' => rand ( 1000000,9999999 ),
        'CouponName' => "PD",
        'CouponAmount' => 10,
        'Offer' => 18,
        'OfferType' => 'percentage',
        'Limit' => 1,
        'Sold' => 0,
        'Status' => 'active',
        'Business' => 'H',
        'CouponExpiredDate' => Carbon::now()->addYear(2),
        'CreatedAt' => Carbon::now(),
        'UpdatedAt' => Carbon::now()
    ];
});
