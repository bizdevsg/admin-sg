<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KantorCabang extends Model
{
    use HasFactory;

    protected $table = 'kantor_cabangs';

    protected $fillable = [
        'nama_kantor_cabang',
        'alamat_kantor_cabang',
        'fax_kantor_cabang',
        'telepon_kantor_cabang',
        'maps_kantor_cabang'
    ];

    public function wakilPialangs(): HasMany
    {
        return $this->hasMany(WakilPialang::class);
    }
}
