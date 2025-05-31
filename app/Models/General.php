<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class General extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'generals';
    protected $primaryKey = 'id';

    protected $fillable = [
        'logo',
        'guidebook',
        'title',
        'subtitle',
        'location',
        'event_start',
        'event_end',
        'last_registration',
        'email',
        'phone',
        'address',
        'instagram',
        'facebook',
        'youtube',
        'tiktok',
        'website',
    ];
}
