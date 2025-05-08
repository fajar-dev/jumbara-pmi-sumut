<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberType extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'member_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];
}
