<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coordinator extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'coordinators';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'contingent_id',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contingent(): BelongsTo
    {
        return $this->belongsTo(Contingent::class);
    }
}
