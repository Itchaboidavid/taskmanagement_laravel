<x-app-layout>
    <script>
        google.charts.load('current', {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            if (document.getElementById('tasksChart')) {


                // Task Chart---------------------------------------------------------------------------------------
                const tasksData = google.visualization.arrayToDataTable([
                    ['Task Status', 'Count'],
                    ['Pending Tasks', {{ $tasks->pendingTasksCount }}],
                    ['In Progress Tasks', {{ $tasks->inProgressTasksCount }}],
                    ['Completed Tasks', {{ $tasks->completedTasksCount }}],
                    ['Total Tasks', {{ $tasks->totalTasksCount }}],
                ]);

                const tasksOptions = {
                    title: 'Tasks Chart',
                    is3D: true
                };

                const tasksChart = new google.visualization.PieChart(document.getElementById('tasksChart'));
                tasksChart.draw(tasksData, tasksOptions);

                // User Chart---------------------------------------------------------------------------------------
                const usersData = google.visualization.arrayToDataTable([
                    ['User', 'Tasks Count'],
                    @foreach ($users as $user)
                        ['{{ $user->name }}', {{ $user->tasks->count() }}],
                    @endforeach
                ]);

                const usersOptions = {
                    title: 'User Chart',
                };

                const usersChart = new google.visualization.BarChart(document.getElementById('usersChart'));
                usersChart.draw(usersData, usersOptions);
            }

            if (document.getElementById('userTasksChart')) {
                // User Task Chart---------------------------------------------------------------------------------------
                const userTasksData = google.visualization.arrayToDataTable([
                    ['Task Status', 'Count'],
                    ['Pending Tasks', {{ $tasks->pendingTasksCount }}],
                    ['In Progress Tasks', {{ $tasks->inProgressTasksCount }}],
                    ['Completed Tasks', {{ $tasks->completedTasksCount }}],
                    ['Total Tasks', {{ $tasks->totalTasksCount }}],
                ]);

                const userTasksOptions = {
                    title: 'Tasks Chart',
                    is3D: true
                };

                const userTasksChart = new google.visualization.PieChart(document.getElementById('userTasksChart'));
                userTasksChart.draw(userTasksData, userTasksOptions);
            }
        }
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid grid-cols-1 md:grid-cols-2 gap-2">
                    @if (Auth::user()->role === 'admin')
                        <div>
                            <div id="tasksChart" class="w-full border shadow-lg"></div>
                            <a href="{{ route('tasks.index') }}"
                                class="block w-full px-3 py-1 text-center bg-green-400 text-white cursor-pointer">
                                View Tasks
                            </a>
                        </div>
                        <div>
                            <div id="usersChart" class="w-full border shadow-lg"></div>
                            <a href="{{ route('users.index') }}"
                                class="block w-full px-3 py-1 text-center bg-blue-400 text-white cursor-pointer">
                                View Users
                            </a>
                        </div>
                    @else
                        <div>
                            <div id="userTasksChart" class="w-full border shadow-lg"></div>
                            <a href="{{ route('tasks.index') }}"
                                class="block w-full px-3 py-1 text-center bg-green-400 text-white cursor-pointer">
                                View Tasks
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
