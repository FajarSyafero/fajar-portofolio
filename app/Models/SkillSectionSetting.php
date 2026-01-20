<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillSectionSetting extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = [
        'title',
        'sub_title',
        'image',
    ];
}
