<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'vet_id',
        'pet_id',
        'appointment_date',
        'status',
    ];

    public function vet()
    {
        return $this->belongsTo(Vet::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
