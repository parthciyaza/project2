<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class info extends Model
{
    
    public $timestamps=false;
    protected $table='info';
    protected $primaryKey='id';
    protected $fillable=['country_id','state_id','city_id'];

}
