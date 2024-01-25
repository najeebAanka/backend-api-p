<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Car extends Model
{

    use Translatable;
    use SoftDeletes;

    protected $translatable = ['name', 'title', 'description'];

    protected $table = 'cars';


    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function model()
    {
        return $this->belongsTo(\App\Models\Model::class, 'model_id');
    }

    public function car_status()
    {
        return $this->belongsTo(Status::class, 'status');
    }

    public function transmissions()
    {
        return $this->belongsToMany(Transmission::class, 'cars_transmissions');
    }

    public function fuel()
    {
        return $this->belongsToMany(Fuel::class, 'cars_fuels');
    }

    public function interior_designs()
    {
        return $this->belongsToMany(InteriorDesign::class, 'cars_interior_designs');
    }

    public function exterior_features()
    {
        return $this->belongsToMany(ExteriorFeature::class, 'cars_exterior_features');
    }

    public function security_environments()
    {
        return $this->belongsToMany(SecurityEnvironment::class, 'cars_security_environments');
    }


    public function car_colors()
    {
        return $this->hasMany(CarColor::class);
    }


}
