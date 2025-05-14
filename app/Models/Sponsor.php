<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsor extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'sponsors';
    protected $primaryKey = 'id';

    protected $fillable = [
        'logo',
        'name',
        'url'
    ];
}
