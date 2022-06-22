<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $primaryKey = 'uid';
    public $incrementing = false;

    public function mekanik_fitur()
    {
        return $this->hasMany(MekanikFitur::class, 'mekanik_uid', 'uid');
    }

    public function job()
    {
        return $this->belongsTo(JobMekanik::class, 'uid', 'mekanik_uid');
    }
}
