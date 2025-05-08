<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityType extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'activity_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];
}
