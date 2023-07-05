<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class combos extends Model
{
    use HasFactory;
    protected $table = "combos";
    protected $primaryKey = 'combo_id'; // Tên cột khóa chính
}
