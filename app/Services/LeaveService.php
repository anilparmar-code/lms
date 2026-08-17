<?php

namespace App\Services;

use App\Events\LeaveStatusChanged;
use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Cache;

class LeaveService
{
    public function changeStatus(Leave $leave, $status): Leave
    {
        $leave->status = $status;
        $leave->save();

        event(new LeaveStatusChanged($leave));

        return $leave;
    }

    public function create($data): Leave
    {
        return auth()->user()->leaves()->create($data);
    }

    public function getLeaveTypes()
    {
        $leave_types = Cache::remember('leave_types', 3600, function () {
            $leave_types = LeaveType::query()->get();

            return serialize($leave_types);
        });

        $leave_types = unserialize($leave_types);

        return $leave_types;
    }
}
