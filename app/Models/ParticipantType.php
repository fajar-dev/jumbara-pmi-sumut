<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParticipantType extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'participant_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'max_participant',
        'class'
    ];
}
