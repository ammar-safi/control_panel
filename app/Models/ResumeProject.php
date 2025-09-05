<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeProject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resume_experiences_id',
        'project',
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
            'resume_experiences_id' => 'integer',
            'updated_at' => 'timestamp',
            'created_at' => 'timestamp',
            'deleted_at' => 'timestamp',
        ];
    }

    public function resumeExperiences(): BelongsTo
    {
        return $this->belongsTo(ResumeExperience::class);
    }

    public function resumeExperiences(): BelongsTo
    {
        return $this->belongsTo(ResumeExperience::class);
    }
}
