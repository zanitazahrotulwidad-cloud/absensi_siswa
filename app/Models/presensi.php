<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $primaryKey = 'id_presensi';

    public $timestamps = false;

    protected $fillable = [
        'id_jadwal_siswa',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'id_presensi' => 'integer',
        'id_jadwal_siswa' => 'integer',
        'tanggal' => 'datetime',
    ];
}