<?php

namespace App\Models;

use App\Models\MemberType;
use App\Models\ParticipantType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberParticipation extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'member_participations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'member_type_id',
        'participant_type_id'
    ];

    public function memberType(): BelongsTo
    {
        return $this->belongsTo(MemberType::class);
    }

    public function participantType(): BelongsTo
    {
        return $this->belongsTo(ParticipantType::class);
    }
}
