<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tours;


class TSProfile extends Model
{
    use HasFactory;

    protected $table = 'ts_profiles';

    protected $fillable = [
        'user_id',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tours(){
        return $this->hasMany(Tours::class, 'ts_id');
    }
}
