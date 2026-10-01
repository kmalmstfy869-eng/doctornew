<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
protected $fillable=[
                    "name",
                    "slug",
];
   public function doctors()
{
    return $this->hasMany(Doctor::class, 'area_id');
}
}
