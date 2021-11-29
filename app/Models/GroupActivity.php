<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupActivity extends Model
{
    use HasFactory;

    public function getActivities(){
        return $this->hasMany(Activity::class, 'group', 'id');
    }

}
