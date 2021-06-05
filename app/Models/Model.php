<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;


class Model extends BaseModel{
    //$guarded has the list of all form field that can be mass assigned,
    //.. when you change it to [] it will be empty, so you don't have to mass assign anything
    protected $guarded = [];

}