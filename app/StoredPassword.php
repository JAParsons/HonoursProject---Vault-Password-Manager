<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoredPassword extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_token', 'email', 'password', 'iv', 'website_name', 'website_url', 'image_url',
    ];
}
