<?php

namespace App\Models;

use App\Models\User;
use App\Models\Contingent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
