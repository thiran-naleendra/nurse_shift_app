<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NurseProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NurseController extends Controller
{
    public function index()
    {
        $nurses = NurseProfile::with('user')->latest()->paginate(15);
        return view('nurses.index', compact('nurses'));
    }

    public function create()
    {
        return view('nurses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable'],
            'password' => ['required', 'min:6'],
            'employee_code' => ['required', 'unique:nurse_profiles,employee_code'],
            'department' => ['nullable'],
            'designation' => ['nullable'],
            'join_date' => ['nullable', 'date'],
            'status' => ['required'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'role' => 'nurse',
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'email_verified_at' => now(),
                'is_active' => 1,
            ]);

            NurseProfile::create([
                'user_id' => $user->id,
                'employee_code' => $data['employee_code'],
                'department' => $data['department'] ?? null,
                'designation' => $data['designation'] ?? null,
                'join_date' => $data['join_date'] ?? null,
                'status' => $data['status'],
            ]);
        });

        return redirect()->route('nurses.index')->with('success', 'Nurse created successfully.');
    }

    public function show(string $id)
    {
        $nurse = NurseProfile::with(['user', 'scheduleEntries.shiftType', 'scheduleEntries.leaveType'])->findOrFail($id);
        return view('nurses.show', compact('nurse'));
    }

    public function edit(string $id)
    {
        $nurse = NurseProfile::with('user')->findOrFail($id);
        return view('nurses.edit', compact('nurse'));
    }

    public function update(Request $request, string $id)
    {
        $nurse = NurseProfile::with('user')->findOrFail($id);

        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $nurse->user->id],
            'phone' => ['nullable'],
            'employee_code' => ['required', 'unique:nurse_profiles,employee_code,' . $nurse->id],
            'department' => ['nullable'],
            'designation' => ['nullable'],
            'join_date' => ['nullable', 'date'],
            'status' => ['required'],
        ]);

        DB::transaction(function () use ($data, $nurse) {
            $nurse->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
            ]);

            $nurse->update([
                'employee_code' => $data['employee_code'],
                'department' => $data['department'] ?? null,
                'designation' => $data['designation'] ?? null,
                'join_date' => $data['join_date'] ?? null,
                'status' => $data['status'],
            ]);
        });

        return redirect()->route('nurses.index')->with('success', 'Nurse updated.');
    }

    public function destroy(string $id)
    {
        $nurse = NurseProfile::findOrFail($id);
        $nurse->delete();

        return redirect()->route('nurses.index')->with('success', 'Nurse deleted.');
    }
}