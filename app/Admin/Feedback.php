<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Feedback extends Model
{
    protected $fillable = ['user_id','description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
