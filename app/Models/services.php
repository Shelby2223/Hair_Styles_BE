<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services extends Model
{
    use HasFactory;
    protected $table= "services";
    public function histories()
    {
        return $this->hasMany(histories::class, 'service_id');
    }
}
