<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    use HasFactory;
    
    protected $table='ratings';
    protected $primaryKey = 'rating_id';
   
    protected $fillable = [
        'rating_star',
        'user_id',
        'shop_id',
        'content'
    ];



    
    public function users()
    {
        return $this->belongsTo(users::class);
    }

    
    public function Shops()
    {
        return $this->belongsTo(shops::class);
    }   
}
