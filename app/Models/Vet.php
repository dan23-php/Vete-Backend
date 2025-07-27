<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
    ];

    // Optional: relationships
    // public function appointments() {
    //     return $this->hasMany(Appointment::class);
    // }
}
