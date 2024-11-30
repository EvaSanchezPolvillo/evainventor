<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subcategory extends Model
{
    use SoftDeletes;
    protected static $articleModel='App\Models\Articles';
    protected $fillable = [
        'name',
        'available',
        'visible',
        'category_id',

    ];

    public function articles()
    {
        return $this->hasMany(self::$articleModel);
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
