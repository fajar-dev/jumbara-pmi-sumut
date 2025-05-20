<?php

namespace App\Models;

use App\Models\MemberParticipation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberType extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'member_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];

    public function memberParticipations(): HasMany
    {
        return $this->hasMany(MemberParticipation::class);
    }
}
