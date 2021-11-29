<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineRecord extends Model
{
    use HasFactory;

    public function getVaccine(){
        return $this->hasOne(Vaccine::class, 'id', 'vaccine');
    }

    public function getPatient(){
        return $this->hasOne(Patient::class, 'id', 'patient');
    }

}
