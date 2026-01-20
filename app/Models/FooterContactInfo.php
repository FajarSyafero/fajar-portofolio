<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterContactInfo extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'address',
        'phone',
        'email',
    ];
}
