<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'job_status',
        'job_type',
        'salary_start',
        'salary_end',
        'job_description',
        'job_location',
        'job_start_time',
        'job_end_time',
        'job_skills',
        'industry_id',
        'company_id',
        'expires_at',
    ];


    protected $casts = [
        'job_skills' => 'array',
        'expires_at' => 'date',
    ];
    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id', 'id');
    }
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'save_job')->withTimestamps();
    }

    protected static function booted()
    {
        static::addGlobalScope('excludeBlockedCompanies', function ($builder) {
            $builder->whereHas('company', function ($query) {
                $query->where('is_blocked', 0);
            });
        });
    }
}
