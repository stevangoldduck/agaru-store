<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id','name','price','ean_number','ean_number_img_path'];

    public function category()
    {
        return $this->hasOne('App\ProductCategory','id','category_id');
    }
}
