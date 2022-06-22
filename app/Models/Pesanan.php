<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid', 'uid');
    }

    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'mekanik_uid', 'uid')->with('job');
    }

    public function fitur()
    {
        return $this->belongsTo(Fitur::class, 'fitur_id', 'id');
    }
}
