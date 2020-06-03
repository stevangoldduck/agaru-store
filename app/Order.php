<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','total','order_barcode','order_barcode_img_path','status'];

    public function details()
    {
        return $this->hasMany('App\OrderDetail','order_id','id');
    }
}
