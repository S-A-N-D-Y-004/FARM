<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurdbatchName extends Model
{
    use HasFactory;

    protected $table = 'curdbatch_name';
    protected $fillable = ['name']; 

}
