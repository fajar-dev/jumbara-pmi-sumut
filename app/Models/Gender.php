<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gender extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'genders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];
}
