<?php

namespace App\Models;

use App\Models\Activity;
use App\Models\MemberType;
use App\Models\ParticipantType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActicityParticipation extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'acticity_participations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'activity_id',
        'participant_type_id',
        'member_type_id',
        'max_participant'
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function participantType(): BelongsTo
    {
        return $this->belongsTo(ParticipantType::class);
    }

    public function memberType(): BelongsTo
    {
        return $this->belongsTo(MemberType::class);
    }
}
