<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employee = Employee::get();
        return view('employees.index', compact('employee'));
    }

    public function create(): View
    {
        $users = User::get();
        return view('employees.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0'
        ]);
        Employee::created($validated);
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Request $request, Employee $employee): View
    {
        $users = User::get();
        return view('employees.edit', compact('users', 'employee'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:user,id',
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0'
        ]);
        $employee->update($validated);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function delete(Employee $employee): RedirectResponse
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
