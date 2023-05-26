<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favors extends Model
{
    use HasFactory;

    protected $table = "favors";

    protected $fillable = [
        'favor_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
