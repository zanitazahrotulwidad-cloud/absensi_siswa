<?php

namespace App\Models;

use Database\Factories\MapelFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['kode', 'nama'])]
class Mapel extends Model
{
    /** @use HasFactory<MapelFactory> */
    use HasFactory;

    protected $table = 'mapel';

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'mapel_id');
    }
}
