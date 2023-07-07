<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class histories extends Model
{
    use HasFactory;
    protected $table = "histories";
    public function service()
    {
        return $this->belongsTo(services::class, 'service_id');
    }
}
