<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class InputItem extends Model
{
    protected $fillable = [
      'name', 'price', 'description', 'picture', 'created-at', 'updated_at'
    ];
}
