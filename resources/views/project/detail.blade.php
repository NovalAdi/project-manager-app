@extends('layout.master')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3 text-gray-800">{{ $project['name'] }}</h1>
            <button type="button" class="btn btn-danger btn-sm mr-3">{{ $dayLeft + 1 }} Days Left</button>
        </div>
        <h6>Deadline : {{ $project['deadline'] }}</h6>
        <h6 class="mb-5">{{ $project['desk'] }}</h6>

        <h4>Participants</h4>
        <div class="card shadow mb-4">
            <div class="card-body">
                <a class="btn btn-primary btn-sm mb-3" href="{{ route('project.add.view', $project['id']) }}">Add
                    Participant</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participants as $key => $employee)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $employee->user->username }}</td>
                                    <td>{{ $employee->user->email }}</td>
                                    <td><img class="mr-4"
                                            src="{{ asset('uploads/users') . '/' . $employee->user->image }}" height="40"
                                            width="40" alt=""></td>
                                    <td>
                                        <form
                                            action="{{ route('project.delete.participant', ['idEmployee' => $employee->id, 'idProject' => $project['id']]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to kick {{ $employee->user->username }} from this project')">Kick</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <h4>Tasks</h4>
        <div class="card shadow mb-4">
            <div class="card-body">
                <a class="btn btn-primary btn-sm mb-3"
                    href="{{ route('project.create.task.view', $project['id']) }}">Create New Task</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Employee Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $key => $task)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->desk }}</td>
                                    <td>{{ $task->employee->user->username }}</td>
                                    <td>{{ $task->status }}</td>
                                    <td>
                                        @if ($task->status == 'done')
                                            <a href="{{ route('project.return.task.view', ['idTask' => $task->id, 'idProject' => $project->id]) }}"
                                                class="btn btn-warning btn-sm">Return</a>
                                        @endif
                                        @if ($task->status == 'pending')
                                            <a href="{{ route('project.return.task.detail', ['idTask' => $task->id, 'idProject' => $project->id]) }}"
                                                class="btn btn-primary btn-sm">Detail</a>
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
@endsection
