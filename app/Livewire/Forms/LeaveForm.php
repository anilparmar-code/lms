<?php

namespace App\Livewire\Forms;

use App\Models\Leave;
use App\Services\LeaveService;
use Flux\Flux;
use Livewire\Form;

class LeaveForm extends Form
{
    public ?Leave $leave = null;

    public ?int $leave_type_id = null;

    public $start_date = null;

    public $end_date = null;

    public ?string $reason = null;

    public ?string $status = null;

    protected function rules(): array
    {
        return [
            'leave_type_id' => ['required', 'integer', 'exists:leave_types,id'],
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'date', 'after_or_equal:start_date'],
            'reason' => ['sometimes', 'string', 'min:3', 'max:255'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        app(LeaveService::class)->create($this->only(['leave_type_id', 'start_date', 'end_date', 'reason']));

        \Flux::toast('Leave created successfully.', 'Leave Created');
    }
}
