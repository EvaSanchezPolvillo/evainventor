<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected static $subcategoryModel = 'App\Models\Subcategory';
    protected static $orderDetail = 'App\Models\OrderDetail';

    protected $fillable = [
        'name',
        'stock',
        'subcategory_id',
        'image',
        'available',
        'visible',
        'status',
    ];

    public function subcategory(){
        return $this->belongsTo(self::$subcategoryModel);
    }

    public function OrderDetail()
    {
        return $this->hasMany(self::$orderDetail);
    }

}
