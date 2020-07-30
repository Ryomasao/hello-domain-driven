<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $guarded = [];
}
