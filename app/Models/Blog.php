<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    public function getCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'category', 'id');
    }
}
