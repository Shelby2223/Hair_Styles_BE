<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\shops;
class ratings extends Model
{
    use HasFactory;
    protected $table = "ratings";
    public function shop()
{
    return $this->belongsTo(shops::class, 'shop_id');
}


}
