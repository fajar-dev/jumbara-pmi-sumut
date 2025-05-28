<?php

namespace App\Models;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContingentLeader extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'contingent_leaders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'participant_id',
    ];
    
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

}
