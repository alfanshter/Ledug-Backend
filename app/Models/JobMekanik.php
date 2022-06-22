<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobMekanik extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public $timestamps = true;

    public function mekanik()
    {
        return $this->hasOne(Mekanik::class, 'uid', 'mekanik_uid');
    }
}
