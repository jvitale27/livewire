<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

//cuando hay insercion masiva, solo guardo en la BD estos campos indicados aqui. Es por seguridad
    protected $fillable = ['title', 'content'];

//cuando hay insercion masiva, NO guardo en la BD estos campos indicados aqui. Lo contrario al anterior
    protected $guarded = [];            //nada que proteger

}
