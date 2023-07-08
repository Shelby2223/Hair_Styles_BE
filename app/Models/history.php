<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history extends Model
{
    use HasFactory;
    protected $table = "histories";
    protected $primaryKey = 'history_id'; // Tên cột khóa chính
    
    protected $fillable = [
        'history_id',
        'shop_id',
        'shop_id',
        'combo_id',
        'payment_id',
    ];

}
