<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">PHP - Simple To Do List App</h1>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <input type="text" id="task" class="form-control" placeholder="Enter Task">
                <button id="addTaskBtn" class="btn btn-primary mt-2">Add Task</button>
                <button id="showAllBtn" class="btn btn-secondary mt-2">Show All Tasks</button>
            </div>
        </div>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="taskList">
            @foreach($tasks as $task)
                <tr data-id="{{ $task->id }}">
                    <td>{{$task->id}}</td>
                    <td>{{ $task->task }}</td>
                    <td>{{ $task->is_completed ? 'Done' : 'Pending' }}</td>
                    <td>
                    @if(!$task->is_completed)
                    <input type="checkbox" class="task-checkbox" >
                    @endif
                        <button class="btn btn-danger delete-task">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<script src="{{ mix('/js/app.js') }}"></script>
<script>
     $(document).ready(function() {
            $('#addTaskBtn').on('click', function() {
                let task = $('#task').val();
                if(task === '') {
                    alert('Task cannot be empty!');
                    return;
                }

                $.ajax({
                    url: '/tasks',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        task: task
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.errors.task[0]);
                    }
                });
            });


            $('.task-checkbox').on('change', function() {
                let row = $(this).closest('tr');
                let taskId = row.data('id');
                let isChecked = $(this).is(':checked');
                    
                $.ajax({
                    url: `/tasks/${taskId}`,
                    method: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_completed: isChecked
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            });
        });
</script>
</body>
</html>