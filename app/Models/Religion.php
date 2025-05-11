<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Religion extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'religions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];
}
