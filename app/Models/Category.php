<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model

{
    use SoftDeletes;
    protected static $subcategoryModel = 'App\Models\Subcategory';
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'available',
        'visible',

    ];
    public function subcategory(){
        return $this->hasMany(self::$subcategoryModel);
    }
}
