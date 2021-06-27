<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class TblUserLoginLog extends Model

{

    protected $fillable = [

        'warehouse_id','delivery_type_id','user_id','login_time','login_date','login_latitude','login_longitude','collected_package','c_returned_package','supervisor_id'

    ];

    

    

    public function UserDetail()

    {

        return $this->hasOne('App\User','id','user_id');

    }

    

    public function warehouseDetail()

    {

        return $this->hasOne('App\TblWarehouse','id','warehouse_id');

    }



    public function supervisorDetail()

    {

        return $this->hasOne('App\User','id','supervisor_id');

    }


        public function deliveryType()

    {

        return $this->hasOne('App\TblDeliveryType','id','delivery_type_id');

    }

        

}

