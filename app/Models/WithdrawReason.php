<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawReason extends Model
{
    protected $fillable = [
        'reason',
        'status'
    ];
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'withdraw_reason_id');
    }
}
