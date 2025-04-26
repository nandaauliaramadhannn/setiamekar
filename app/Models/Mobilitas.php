<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobilitas extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'mobilitas';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
