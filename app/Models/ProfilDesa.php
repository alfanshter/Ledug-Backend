<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'regencie_id', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }
}
