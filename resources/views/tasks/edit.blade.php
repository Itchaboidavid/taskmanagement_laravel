<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Task') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold text-slate-800 text-center">Edit Task</h2>
                    {{-- FORM GOES HERE --}}
                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="w-1/2 mx-auto space-y-5">
                        @csrf
                        @method('PUT')
                        <x-text-input name="title" id="title" placeholder="Title" class="w-full"
                            value="{{ $task->title }}" :readonly="!Auth::user()->isAdmin()" />
                        <x-text-input name="description" id="description" placeholder="Description" class="w-full"
                            value="{{ $task->description }}" :readonly="!Auth::user()->isAdmin()" />
                        <select name="status" id="status"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                            <option value="{{ $task->status }}" selected>
                                {{ ucwords(str_replace('_', ' ', $task->status)) }}</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        @if (Auth::user()->role === 'admin')
                            <x-select name="user_id" id="user_id">
                                <option value="{{ $task->user_id }}" selected>{{ $task->user->name }}</option>
                                @foreach ($users as $user)
                                    @if ($user->id !== $task->user_id)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </x-select>
                        @else
                            <input type="hidden" name="user_id" value="{{ $task->user_id }}">
                        @endif
                        <div class='flex justify-end space-x-4'>
                            <x-primary-button>Update</x-primary-button>
                            <x-danger-link href="{{ route('tasks.index') }}">Cancel</x-danger-link>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
