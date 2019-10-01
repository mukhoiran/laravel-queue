<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    // whitelist
    protected $fillable = ['title','description'];
}
