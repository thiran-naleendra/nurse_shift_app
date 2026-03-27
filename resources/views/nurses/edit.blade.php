@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Nurse</h1>
            <p class="text-sm text-slate-500">Update nurse profile and account details</p>
        </div>

        <a href="{{ route('nurses.index') }}"
           class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
            Back
        </a>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-lg sm:p-8">
        <form method="POST" action="{{ route('nurses.update', $nurse->id) }}" class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @csrf
            @method('PUT')

            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-medium text-slate-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $nurse->user->name) }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $nurse->user->email) }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $nurse->user->phone) }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Employee Code</label>
                <input type="text" name="employee_code" value="{{ old('employee_code', $nurse->employee_code) }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Department</label>
                <input type="text" name="department" value="{{ old('department', $nurse->department) }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Designation</label>
                <input type="text" name="designation" value="{{ old('designation', $nurse->designation) }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Join Date</label>
                <input type="date" name="join_date" value="{{ old('join_date', $nurse->join_date) }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                <select name="status"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    <option value="active" {{ old('status', $nurse->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $nurse->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="md:col-span-2 pt-2">
                <button class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                    Update Nurse
                </button>
            </div>
        </form>
    </div>
</div>
@endsection