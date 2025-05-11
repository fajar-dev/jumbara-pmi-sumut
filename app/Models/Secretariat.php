<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Secretariat extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'secretariats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category',
        'type',
        'name',
        'address',
        'phone',
        'email',
        'administrative_area_level_1',
        'administrative_area_level_2',
    ];
}
