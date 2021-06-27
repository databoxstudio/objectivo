<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblWarehouse extends Model
{
    protected $fillable = [
        'name', 'address', 'state_id', 'city_id', 'zipcode'
    ];
    
    public function State()
    {
        return $this->hasOne('App\TblState','id','state_id');
    }
    
    public function City()
    {
        return $this->hasOne('App\TblCity','id','city_id');
    }

}
