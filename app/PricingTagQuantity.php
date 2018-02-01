<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricingTagQuantity extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function pricing()
    {
        return $this->belongsTo('App\Pricing');
    }
}
