<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloodType extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'blood_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];
}
