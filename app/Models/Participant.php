<?php

namespace App\Models;

use App\Models\ParticipantType;
use App\Models\ParticipantAssignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'participants';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'contingent_id',
        'participant_type_id',
        'health_certificate',
        'assignment_letter',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contingent(): BelongsTo
    {
        return $this->belongsTo(Contingent::class);
    }

    public function participantType(): BelongsTo
    {
        return $this->belongsTo(ParticipantType::class);
    }

     public function participantAssignment(): HasMany
    {
        return $this->hasMany(ParticipantAssignment::class);
    }
}
