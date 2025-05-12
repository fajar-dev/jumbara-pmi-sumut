<?php

namespace App\Models;

use App\Models\Activity;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParticipantAssignment extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'participant_assignments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'participant_id',
        'activity_id',
    ];
    
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
