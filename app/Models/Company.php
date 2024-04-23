<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'email', 'description', 'website', 'logo'];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps(); // Assuming pivot table has timestamps
    }
}
