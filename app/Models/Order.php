<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected static $userModel = 'App\Models\User';
    protected static $orderDetail = 'App\Models\OrderDetail';

    protected $fillable = [
        'status',
        'user_id',

    ];
    public function OrderDetail()
    {
        return $this->hasMany(self::$orderDetail);
    }
    public function user(){
        return $this->belongsTo(self::$userModel);
    }
}
