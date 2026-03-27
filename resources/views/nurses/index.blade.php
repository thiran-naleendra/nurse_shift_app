@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Nurses</h1>
            <p class="text-sm text-slate-500">Manage nurse accounts and profile details</p>
        </div>

        <a href="{{ route('nurses.create') }}"
           class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
            Add Nurse
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-sm text-slate-600">
                        <th class="px-6 py-4 font-semibold">Name</th>
                        <th class="px-6 py-4 font-semibold">Employee Code</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold">Department</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($nurses as $nurse)
                        <tr>
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $nurse->user->name }}</td>
                            <td class="px-6 py-4">{{ $nurse->employee_code }}</td>
                            <td class="px-6 py-4">{{ $nurse->user->email }}</td>
                            <td class="px-6 py-4">{{ $nurse->department ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($nurse->status === 'active')
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('nurses.show', $nurse->id) }}"
                                       class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                                        View
                                    </a>

                                    <a href="{{ route('nurses.edit', $nurse->id) }}"
                                       class="rounded-xl bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('nurses.destroy', $nurse->id) }}"
                                          onsubmit="return confirm('Delete this nurse?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">
                                No nurses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $nurses->links() }}
    </div>
</div>
@endsection