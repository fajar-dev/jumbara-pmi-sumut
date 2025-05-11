<?php

namespace App\Models;

use App\Models\User;
use App\Models\CrewAssignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Crew extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'crews';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function CrewAssignment(): HasMany
    {
        return $this->hasMany(CrewAssignment::class);
    }
}