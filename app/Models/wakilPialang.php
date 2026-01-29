<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WakilPialang extends Model
{
    use HasFactory;

    protected $table = 'wakil_pialangs';

    protected $fillable = [
        'kantor_cabang_id',
        'image',
        'nomor_id',
        'nama',
        'status',
    ];

    public function kantorCabang(): BelongsTo
    {
        return $this->belongsTo(KantorCabang::class);
    }
}
