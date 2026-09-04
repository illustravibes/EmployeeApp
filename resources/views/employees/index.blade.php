<?php

use App\Models\Employee;
use App\Models\User;
use Livewire\Component;

$users = User::all();

new class extends Component {
    public $users;
    public $full_name;
    public $age;
    public $user_id;

    public function mount()
    {
        $this->users = User::all();
    }

    public function save()
    {
        $this->validate([
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'user_id' => 'required|exists:users,id'
        ]);
        Employee::create(
            $this->only(['full_name', 'age', 'user_id'])
        );

        session()->flash('status', 'Employee successfully created.');

        return $this->redirect('/employees');
    }
};
?>

<x-layouts::app :title="__('Employee')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between">
            <h1>Employees</h1>
            <flux:modal.trigger name="create-employee">
                <flux:button>Create Employee</flux:button>
            </flux:modal.trigger>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <flux:table :rows="$employee">
                <flux:table.columns>
                    <flux:table.column>No</flux:table.column>
                    <flux:table.column>Full Name</flux:table.column>
                    <flux:table.column>Age</flux:table.column>
                    <flux:table.column>Action</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($employee as $employee)
                    <flux:table.row :data="$employee" wire:navigate :href="route('employees.show', $employee)">
                        <flux:table.cell>{{ $loop->iteration }}</flux:table.cell>
                        <flux:table.cell>{{ $employee->full_name }}</flux:table.cell>
                        <flux:table.cell>{{ $employee->age }}</flux:table.cell>
                        <flux:table.cell>
                            <a href="{{ route('employees.edit', $employee) }}" wire:navigate>Edit</a>
                            <a href="{{ route('employees.show', $employee) }}" wire:navigate>Show</a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </flux:table.cell>
                    </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>
    </div>
</x-layouts::app>

<flux:modal name="create-employee" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Create Employee</flux:heading>
            <flux:text class="mt-2">Make changes to your personal details.</flux:text>
        </div>
        <form wire:submit="save">
            <flux:select wire:model="user_id" label="Select User">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </flux:select>
            <flux:input wire:model="full_name" label="Full Name" placeholder="Enter your full name" />
            <flux:input wire:model="age" label="Age" placeholder="Enter your age" type="number" />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Create Employee</flux:button>
            </div>
        </form>
</flux:modal>


<!-- <flux:modal.trigger name="edit-profile">
    <flux:button>Edit profile</flux:button>
</flux:modal.trigger>

<flux:modal name="edit-profile" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Update profile</flux:heading>
            <flux:text class="mt-2">Make changes to your personal details.</flux:text>
        </div>

        <flux:input label="Name" placeholder="Your name" />

        <flux:input label="Date of birth" type="date" />

        <div class="flex">
            <flux:spacer />

            <flux:button type="submit" variant="primary">Save changes</flux:button>
        </div>
    </div>
</flux:modal> -->