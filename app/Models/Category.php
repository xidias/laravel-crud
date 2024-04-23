<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   //use HasFactory;
   protected $fillable = ['name', 'description'];

   public function companies()
   {
       return $this->belongsToMany(Company::class)->withTimestamps(); // Assuming pivot table has timestamps
   }

}
