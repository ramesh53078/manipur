<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class TimeWall extends Model
{
    protected $fillable = ['video_thumbnail','video_name','video_filename','video_path'];
}
