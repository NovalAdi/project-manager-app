@extends('layout.master')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-5 align-items-center">
            <h1 class="h3 mb-2 text-gray-800">Create Task</h1>
            <a href="{{ route('project.show', $project->id) }}" class="btn btn-primary">Back</a>
        </div>

        <div class="card shadow mb-4 mt-2">
            <div class="card-body">
                <form method="POST" action="{{ route('project.create.task', $project->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name_edit">Name</label>
                        <input required type="" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name_edit">Description</label>
                        <input required type="" name="desk" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name_edit">Employee</label>
                        <select class="form-control" name="employee_id">
                            @foreach ($participants as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save fa-fw"></i> SAVE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
