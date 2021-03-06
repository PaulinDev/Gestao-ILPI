<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientInventory extends Model
{
    use HasFactory;

    public function getTypeInventory()
    {
        return $this->hasOne(InventoryType::class, 'id', 'type');
    }

}
