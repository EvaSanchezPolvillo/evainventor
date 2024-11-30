<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'article_id',
        'quantity',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
