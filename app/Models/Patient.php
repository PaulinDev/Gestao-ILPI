<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    public function getGender()
    {
        return $this->hasOne(Gender::class, 'id', 'gender');
    }

    public function getCivil()
    {
        return $this->hasOne(Civil::class, 'id', 'civil');
    }

    public function getEducation()
    {
        return $this->hasOne(Education::class, 'id', 'education');
    }

    public function getOccupation()
    {
        return $this->hasOne(Occupation::class, 'id', 'occupation');
    }

    public function getSituation()
    {
        return $this->hasOne(Situation::class, 'id', 'situation');
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }

    public function getActivities()
    {
        return $this->hasMany(EventActivity::class, 'patient', 'id');
    }

    public function getVaccines()
    {
        return $this->hasMany(VaccineRecord::class, 'patient', 'id');
    }
}
