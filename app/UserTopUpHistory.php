<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTopUpHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_topup_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','amount'];
}
