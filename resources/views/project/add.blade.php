@extends('layout.master')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h1 class="h3 mb-2 text-gray-800">Edit Project Data</h1>
            <a href="{{ route('project.show', $project->id) }}" class="btn btn-primary">Back</a>
        </div>
        <h6 class="mb-5">Write your employee's email to add them to your project</h6>

        <div class="card shadow mb-4 mt-2">

            <div class="card-body">
                <form method="POST" action="{{ route('project.add', $project->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Employee's Email</label>
                        <input required type="" name="email" id="name_edit" class="form-control">
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
