<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pricing extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function printing_type()
    {
        return $this->belongsTo('App\PrintingType');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function printer()
    {
        return $this->belongsTo('App\Printer');
    }

    public function operator()
    {
        return $this->belongsTo('App\Operator');
    }

    public function paper()
    {
        return $this->belongsTo('App\Paper');
    }

    public function pricing_tag_quantities()
    {
        return $this->hasMany('App\PricingTagQuantity');
    }
}
