<?php

namespace App\Models;

use App\Models\ActivityType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'activities';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'activity_type_id',
        'start',
        'end',
        'max_participant',
    ];

    public function activityType(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class);
    }
}
