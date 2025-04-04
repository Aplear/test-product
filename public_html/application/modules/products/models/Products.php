<?php
namespace App\modules\products\models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Products extends Eloquent
{
    protected $primaryKey = 'uuid';
    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name', 'price','category'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
    public $timestamps = false;

}
