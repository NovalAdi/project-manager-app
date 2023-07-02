@extends('layout.master')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-5 align-items-center">
            <h1 class="h3 mb-2 text-gray-800">Send a message to return the task</h1>
            <a href="{{ route('project.show', $project->id) }}" class="btn btn-primary">Back</a>
        </div>

        <div class="card shadow mb-4 mt-2">
            <div class="card-body">
                <form method="POST"
                    action="{{ route('project.return.task', ['idTask' => $task->id, 'idProject' => $project->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name_edit">message</label>
                        <input required type="" name="message" class="form-control">
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
