<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between">
        
                @if (Auth::check())
                    <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                @else
                    <a href="{{ route('loginpage') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('signup') }}" class="btn btn-secondary">Signup</a>
                @endif

                @if (Auth::check() && Auth::user()->is_admin == 1)
                    <a href="{{ route('add-tasks') }}" class="btn btn-success">Add New Tasks</a>
                    <a href="{{ route('user-request') }}" class="btn btn-success">View User Requests</a>
                @endif
            </div>
        </div>

        <!-- Task Table -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5>Task Listing</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Task For</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>
                                    @foreach($task->taskFor as $taskFor)
                                        {{ $taskFor->user->name ?? 'N/A' }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @if (Auth::check() && $task->is_completed == 0)
                                        @foreach($task->taskFor as $taskFor)
                                            @if ($taskFor->task_for == Auth::id())
                                                <form action="{{ route('complete-task', $task->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">Complete Task</button>
                                                </form>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="text-muted">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
