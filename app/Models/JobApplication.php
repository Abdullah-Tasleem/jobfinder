<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'resume',
        'withdraw_reason_id',
        'status',
        'is_seen',
    ];
    protected $casts = [
        'is_seen' => 'boolean',
    ];
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }
    public function withdrawReason()
    {
        return $this->belongsTo(WithdrawReason::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
