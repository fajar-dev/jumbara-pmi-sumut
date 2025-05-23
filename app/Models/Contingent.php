<?php

namespace App\Models;

use App\Models\Coordinator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contingent extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'contingents';
    protected $primaryKey = 'id';

    protected $fillable = [
        'administrative_area_level_1',
        'administrative_area_level_2',
        'name',
    ];

    public function coordinator(): HasOne
    {
        return $this->hasOne(Coordinator::class);
    }
}
