<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LEDData extends Model
{
    use HasFactory;
    protected $table = 'led_data';

    protected $fillable = [
        'led_name', 'pin', 'status'
    ];
}
