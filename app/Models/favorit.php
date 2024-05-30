<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorit extends Model
{
    use HasFactory;

    protected $table = 'data_fav';

    protected $fillable = [
        'user_id',
        'buku_id',
        'is_active'
    ];
}
