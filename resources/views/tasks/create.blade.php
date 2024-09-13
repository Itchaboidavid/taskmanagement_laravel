<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Task') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold text-slate-800 text-center">Create a new task</h2>
                    {{-- FORM GOES HERE --}}
                    <form action="{{ route('tasks.store') }}" method="POST" class="w-1/2 mx-auto space-y-5">
                        @csrf
                        <x-text-input name="title" id="title" placeholder="Title" class="w-full" />
                        <x-text-input name="description" id="description" placeholder="Description" class="w-full" />
                        <select name="status" id="status"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                            <option value="" selected>Status</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <select name="user_id" id="user_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                            <option value="" selected>Assign User</option>
                            @foreach ($users as $user)
                                @if ($user->role !== 'admin')
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class='flex justify-end space-x-4'>
                            <x-primary-button>Create Task</x-primary-button>
                            <x-danger-link href="{{ route('tasks.index') }}">Cancel</x-danger-link>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
