<?php

use App\Models\Employee;
use Livewire\Component;
use App\Models\Post;

new class extends Component {
    public $title = '';

    public $content = '';

    public function save()
    {
        Employee::create(
            $this->only(['title', 'content'])
        );

        session()->flash('status', 'Employee successfully updated.');

        return $this->redirect('/employees');
    }
};
?>

<form wire:submit="save">
    <input type="text" wire:model="title">

    <input type="text" wire:model="content">

    <button type="submit">Save</button>
</form>