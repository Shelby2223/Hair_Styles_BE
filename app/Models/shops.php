<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shops extends Model
{
    use HasFactory;
    protected $table = "shops";
    protected $primaryKey = 'shop_id'; // Tên cột khóa chính

    public function users()
    {
        return $this->belongsTo(users::class);
    }
    
    public function ratings()
    {
    return $this->hasMany(ratings::class);
    }


}
