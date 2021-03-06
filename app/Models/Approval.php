<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'approved',
        'reason',
        'approvable_id',
        'approvable_type',
        'approved_by_id',
        'approved_name',
    ];

    protected $with = ['approved_by'];

    protected $casts = ['approved' => 'boolean'];

    public function approvable()
    {
        return $this->morphTo();
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAcceptedByAnyone($query)
    {
        return $query->where('approved', true);
    }

    public function isAcceptedByAnyone()
    {
        return (bool) $this->approved;
    }

    public function scopeRejectedByAnyone($query)
    {
        return $query->where('approved', false);
    }

    public function isRejectedByAnyone()
    {
        return (bool) $this->approved;
    }

    public function isUnapproved()
    {
        return is_null($this->approved);
    }

    public function scopeUnapproved($query)
    {
        return $query->whereNull('approved');
    }

    public function isApprovedByAdmin()
    {
        return $this->isApprovedByAnyone() && $this->approved_by->isAdmin();
    }

    public function scopeApprovedByAdmin($query)
    {
        return $query->accepted()->byAdmin();
    }

    public function scopeByAdmin($query)
    {
        $query->whereHas('approved_by', function ($q) {
            return $q->where('user_type', 'Admin');
        });
    }

    public function isApprovedBySupervisor()
    {
        return $this->isApprovedByAnyone() && $this->approved_by->isStaff();
    }

    public function scopeBySupervisor($query)
    {
        $query->whereHas('approved_by', function ($q) {
            return $q->where('user_type', 'Staff');
        });
    }
}
