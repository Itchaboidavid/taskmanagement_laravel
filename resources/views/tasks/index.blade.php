<x-app-layout>
    {{-- DATA TABLES --}}
    <script>
        $(document).ready(function() {
            $('#taskTable').DataTable();
        });
    </script>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
            </h2>
            {{-- SESSION MESSAGE --}}
            <x-auth-session-status :status="session('status')"></x-auth-session-status>
            {{-- CREATE TASK BUTTON --}}
            @if ($user->isAdmin())
                <x-primary-link href="{{ route('tasks.create') }}">Create New Task</x-primary-link>
            @else
                <div></div>
            @endif
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- TASK TABLE --}}
                    <table id="taskTable" class="display">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Task Owner</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $task->status)) }}</td>
                                    <td>{{ $task->user->name }}</td>
                                    <td class="flex items-center space-x-2">
                                        <x-primary-link href="{{ route('tasks.edit', $task) }}">Edit</x-primary-link>
                                        @if ($user->isAdmin())
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button>Delete</x-danger-button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
