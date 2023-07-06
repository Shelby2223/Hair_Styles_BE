<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    use HasFactory;
    protected $table = "payments";
    protected $primaryKey = 'payment_id'; // Tên cột khóa chính

    public function users()
    {
        return $this->belongsTo(users::class);
    }
    public function Shops()
    {
        return $this->belongsTo(shops::class);
    }
}
