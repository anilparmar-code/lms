<div>

    <div class="flex justify-between">
        <div>
            <flux:heading>Leaves</flux:heading>
            <flux:text>Manage Leaves</flux:text>
        </div>
        <div>
            <flux:modal.trigger name="manage-leave">
                <flux:button variant="primary">Apply Leave</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <flux:table :paginate="$leaves" class="mt-6">
        <flux:table.columns>
            <flux:table.column>Type</flux:table.column>
            <flux:table.column>Start Date</flux:table.column>
            <flux:table.column>End Date</flux:table.column>
            <flux:table.column>Reason</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Created At</flux:table.column>
            @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                <flux:table.column>Action</flux:table.column>
            @endif
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($leaves as $leave)
                <flux:table.row :key="$leave->id">
                    <flux:table.cell>
                        {{ $leave->leaveType->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $leave->start_date->format('d M, Y') }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $leave->end_date->format('d M, Y') }}
                    </flux:table.cell>

                    <flux:table.cell class="max-w-20">
                        <flux:tooltip content="{{ $leave->reason }}" position="top">
                            <p class="truncate">{{ $leave->reason }}</p>
                        </flux:tooltip>

                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge variant="solid" size="sm" color="{{ $leave->status->color() }}">
                            {{ $leave->status }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $leave->created_at->diffForHumans() }}
                    </flux:table.cell>

                    @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                        <flux:table.cell>
                            <flux:button wire:click="openChangeStatusModal({{ $leave->id }})">Change Status</flux:button>
                        </flux:table.cell>
                    @endif
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>


    <!-- Manage Leave -->
    <flux:modal name="manage-leave" class="md:w-lg">
        <form class="space-y-6" wire:submit="save">
            <div>
                <flux:heading size="lg">Apply For Leave</flux:heading>
                <flux:text class="mt-2">Make changes to your personal details.</flux:text>
            </div>

            <flux:field>
                <flux:label badge="Required">Start Date</flux:label>
                <flux:input wire:model="form.start_date" type="date"  />
                <flux:error name="form.start_date" />
            </flux:field>

            <flux:field>
                <flux:label badge="Required">End Date</flux:label>
                <flux:input wire:model="form.end_date" type="date"  />
                <flux:error name="form.end_date" />
            </flux:field>

            <flux:field>
                <flux:label badge="Required">Leave Type</flux:label>
                <flux:select wire:model="form.leave_type_id">
                    <flux:select.option value="">select leave type</flux:select.option>
                    @foreach($leave_types as $leave_type)
                        <flux:select.option value="{{ $leave_type->id }}">{{ $leave_type->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field>
                <flux:label badge="Required">Reason</flux:label>
                <flux:input wire:model="form.reason" type="text"  />
                <flux:error name="form.reason" />
            </flux:field>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Change status -->
    @if(auth()->user()->hasAnyRole(['admin', 'manager']))
        <flux:modal name="change-status" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Approve or Reject Leave?</flux:heading>
                    <flux:text class="mt-2">
                        Are you sure you want to change status.<br>
                        This action cannot be reversed.
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:button variant="danger" wire:click="changeStatus('rejected')">Reject</flux:button>
                    <flux:button variant="primary" color="emerald" wire:click="changeStatus('approved')">Approve</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
