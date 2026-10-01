<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Specialties extends Model
{
protected $table="specialties";

protected $fillable=[
                        "name",
                        "slug",
                        "title",
                        "logo",
                        "sort_order"
              ];
public function doctors()
{
    return $this->hasMany(Doctor::class, 'specialty_id');
}}
