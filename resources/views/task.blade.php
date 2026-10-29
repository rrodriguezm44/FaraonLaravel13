<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Real Time Tasks</h1>

    <form id="taskForm">
        @csrf
        <input type="text" id="taskInput" placeholder="Enter task description" required>
        <button type="submit">
            Add Task
        </button>
    </form>
    <ul id="task-list">
        <!-- Tasks will be appended here -->
        @foreach ($tasks as $task)
            <li>
                {{ $task->description }}
            </li>
        @endforeach
    </ul>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.0/echo.iife.js"></script>

    <script>
        // axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('REVERB_APP_KEY') }}',
            wsHost: '127.0.0.1',
            wsPort: {{ env('REVERB_PORT', 8080) }},

            forceTLS: false,
            enabledTransports: ['ws', 'wss'],
            cluster: 'mt1',
        });

        window.Echo.channel('tasks')
            .listen('.task.created', (data) => {
                addTaskToList(data.task.description);
            });

        function addTaskToList(taskDescription) {

            const li = document.createElement('li');
            li.textContent = taskDescription;
            document.getElementById('task-list').prepend(li);
        }

        document.getElementById('taskForm').addEventListener('submit', async (e) => {

            e.preventDefault();

            const input = document.getElementById('taskInput');

            await axios.post('/tasks', {
                description: input.value.trim(),
                // _token: '{{ csrf_token() }}',
            });

            input.value = '';

        })
    </script>

</html>
