<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'dice_1',
        'dice_2',
        'won'
    ];
    protected $casts = [
        'won' => 'boolean'
    ];

    public function user() { 
        return $this->belongsTo(User::class); 
    } 
}
