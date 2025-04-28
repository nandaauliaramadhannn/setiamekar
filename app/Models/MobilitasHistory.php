<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobilitasHistory extends Model
{
    use HasFactory;

    protected $table = 'mobilitas_histories';
    protected $guarded = [];

    public function mobilitas()
    {
        return $this->belongsTo(Mobilitas::class);
    }

    public function pegawaiAwal()
    {
        return $this->belongsTo(User::class, 'pegawai_awal_id');
    }

    public function pegawaiPengganti()
    {
        return $this->belongsTo(User::class, 'pegawai_pengganti_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
