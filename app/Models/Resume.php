<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resume extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'path',
        'is_readable',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'user_id' => 'integer',
            'is_readable' => 'boolean',
            'updated_at' => 'timestamp',
            'created_at' => 'timestamp',
            'deleted_at' => 'timestamp',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resumeCandidates(): HasMany
    {
        return $this->hasMany(ResumeCandidate::class);
    }

    public function resumeExperiences(): HasMany
    {
        return $this->hasMany(ResumeExperience::class);
    }

    public function resumeEducations(): HasMany
    {
        return $this->hasMany(ResumeEducation::class);
    }

    public function resumeSkills(): HasMany
    {
        return $this->hasMany(ResumeSkill::class);
    }

    public function resumeLanguages(): HasMany
    {
        return $this->hasMany(ResumeLanguage::class);
    }

    public function resumeVolunteers(): HasMany
    {
        return $this->hasMany(ResumeVolunteer::class);
    }

    public function resumeInterests(): HasMany
    {
        return $this->hasMany(ResumeInterest::class);
    }
}
