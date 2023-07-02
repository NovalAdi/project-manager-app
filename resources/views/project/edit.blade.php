@extends('layout.master')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Edit Project Data</h1>
        <a href="{{ route('project.index') }}" class="btn btn-primary">Back</a>

        <div class="card shadow mb-4 mt-2">

            <div class="card-body">
                <form method="POST" action="{{ route('project.update', $project->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name_edit">Name</label>
                        <input required type="" value="{{ $project->name }}" name="name" id="name_edit"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name_edit">Description</label>
                        <input required type="" value="{{ $project->desk }}" name="desk" id="name_edit"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="gender_edit">Deadline</label>
                        <input required type="date" value="{{ $project->deadline }}" name="desk" id="name_edit"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save fa-fw"></i> SAVW
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
