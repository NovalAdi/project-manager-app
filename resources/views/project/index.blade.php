@extends('layout.master')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Project Data</h1>
        <a class="btn btn-success mb-3 mr-3" href="{{ route('project.create.view') }}">Create Project</a>
    </div>

    <h6 class="mb-5">Total Project : {{ count($projects) }}</h6>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Decription</th>
                            <th>Deadline</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $key => $project)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $project['name'] }}</td>
                                <td>{{ $project['desk'] }}</td>
                                <td>{{ $project['deadline'] }}</td>
                                <td>
                                    <a href="{{ route('project.show', $project['id']) }}" class="btn btn-primary btn-sm">Show More</a>
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
