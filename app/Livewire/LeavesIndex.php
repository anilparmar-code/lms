<?php

namespace App\Livewire;

use App\Livewire\Forms\LeaveForm;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Services\LeaveService;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class LeavesIndex extends Component
{
    use WithPagination;

    public LeaveForm $form;

    public ?int $leaveStatusId = null;

    public function save()
    {
        $this->form->save();

        $this->modal('manage-leave')->close();
    }

    public function openChangeStatusModal($id): void
    {
        $this->leaveStatusId = $id;
        $this->modal('change-status')->show();
    }

    public function changeStatus($status): void
    {
        abort_if(! auth()->user()->hasAnyRole(['admin', 'manager']), 403);

        $leave = Leave::findOrFail($this->leaveStatusId);

        app(LeaveService::class)->changeStatus($leave, $status);

        $this->modal('change-status')->close();

        Flux::toast('Leave status has been changed', 'Status Updated');
    }

    public function render(LeaveService $leaveService): Factory|\Illuminate\Contracts\View\View|View
    {
        $leaves = Leave::query()
            ->with('leaveType')
            ->when(auth()->user()->hasRole('employee'), fn ($query) => $query->where('user_id', auth()->id()))
            ->latest()
            ->paginate(10);

        $leave_types = $leaveService->getLeaveTypes();

        return view('livewire.leaves-index', compact('leaves', 'leave_types'));
    }
}
