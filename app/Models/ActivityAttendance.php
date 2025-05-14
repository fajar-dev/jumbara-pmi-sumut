<?php

namespace App\Models;

use App\Models\CrewAssignment;
use App\Models\ParticipantAssignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityAttendance extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'activity_attendances';
    protected $primaryKey = 'id';

    protected $fillable = [
        'participant_assignment_id',
        'crew_assignments_id',
        'ip_address',
        'user_agent',
        'longitude',
        'latitude',
    ];

    public function participantAssignment(): BelongsTo
    {
        return $this->belongsTo(ParticipantAssignment::class);
    }

    public function crewAssignment(): BelongsTo
    {
        return $this->belongsTo(CrewAssignment::class);
    }
}
