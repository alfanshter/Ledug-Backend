<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiDesa extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function provinsi()
    {
        return $this->hasOne('App\Models\Province');
    }
    
}