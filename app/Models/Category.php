<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public const TABLE = 'categories';
    protected $table =  self::TABLE;

    protected $fillable = [
        'name' ,
        'description' ,
        'photo'
    ];

}
