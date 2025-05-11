<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'faqs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'content',
    ];
}
