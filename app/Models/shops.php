<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\addresses;
use App\Models\ratings;
class shops extends Model
{
    use HasFactory;
    protected $table = "shops";
    protected $primaryKey = 'shop_id'; // Tên cột khóa chính


    public function addresses()
    {
        return $this->hasMany(addresses::class, 'shop_id');
    }
    public function ratings()
{
    return $this->hasMany(ratings::class, 'shop_id');
}

}
