<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Gender;
use App\Models\Religion;
use App\Models\BloodType;
use App\Models\MemberType;
use App\Models\Participant;
use App\Models\Secretariat;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'name',
        'email',
        'gender_id',
        'religion_id',
        'blood_type_id',
        'phone_number',
        'birth_place',
        'birth_date',
        'password',
        'is_default',
        'photo_path',
        'secretariat_id',
        'member_type_id',
        'address',
        'data',
        'joined_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    public function bloodType(): BelongsTo
    {
        return $this->belongsTo(BloodType::class);
    }

    public function secretariat(): BelongsTo
    {
        return $this->belongsTo(Secretariat::class);
    }
    
    public function memberType(): BelongsTo
    {
        return $this->belongsTo(MemberType::class);
    }

    public function participant(): HasOne
    {
        return $this->hasOne(Participant::class);
    }
}
