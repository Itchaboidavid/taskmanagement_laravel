<x-app-layout>
    {{-- DATA TABLES --}}
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- TASK TABLE --}}
                    <table id="userTable" class="display">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Pending Task</th>
                                <th>In Progress Task</th>
                                <th>Completed Task</th>
                                <th>Total Assigned Task</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->pendingTasksCount }}</td>
                                    <td>{{ $user->inProgressTasksCount }}</td>
                                    <td>{{ $user->completedTasksCount }}</td>
                                    <td>{{ $user->totalTasksCount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
