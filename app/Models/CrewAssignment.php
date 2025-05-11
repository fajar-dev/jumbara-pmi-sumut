<?php

namespace App\Models;

use App\Models\Crew;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrewAssignment extends Model
{
    public $timestamps = true;
    protected $table = 'crew_assignments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'crew_id',
        'activity_id',
    ];
    
    public function crew(): BelongsTo
    {
        return $this->belongsTo(Crew::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
