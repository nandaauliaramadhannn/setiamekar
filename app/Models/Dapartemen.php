<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dapartemen extends Model
{
    use HasFactory;

    protected $table = 'departemen';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
