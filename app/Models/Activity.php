<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    public function getGroup(){
        return $this->hasOne(GroupActivity::class, 'id', 'group');
    }

}
