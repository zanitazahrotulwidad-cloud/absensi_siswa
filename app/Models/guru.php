<?php

namespace App\Models;

use Database\Factories\GuruFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'nip', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'alamat'])]
class Guru extends Model
{
    /** @use HasFactory<GuruFactory> */
    use HasFactory;

    protected $table = 'guru';

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    /**
     * Email akun login milik guru.
     */
    public function emailAkun(): ?string
    {
        return User::where('id', $this->user_id)->value('email');
    }

    /**
     * Daftar kelas unik yang diajar guru.
     *
     * @return array<int, string>
     */
    public function kelasDiampu(): array
    {
        return Jadwal::where('guru_id', $this->id)
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas')
            ->all();
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'guru_id');
    }
}
