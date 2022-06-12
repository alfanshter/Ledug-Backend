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
}
