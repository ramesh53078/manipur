<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['user_id','description'];
}
