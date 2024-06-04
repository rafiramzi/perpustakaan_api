<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rental extends Model
{
    use HasFactory;

    protected $table = 'data_rental';

    protected $fillable = [
        'user_id',
        'rental_book_id',
        'rental_date',
        'rental_deadline',
        'qty',
        'condition_role',
        'status',
        'alamat',
        'denda'
    ];
}
