<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shops extends Model
{
    use HasFactory;
    protected $table = "shops";
    protected $primaryKey = 'shop_id'; // Tên cột khóa chính


}