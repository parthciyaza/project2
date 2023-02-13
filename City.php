<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps=false;
    protected $table='cities';
    protected $primaryKey='ci_id';
    protected $fillable=['ci_name','s_id'];
}
