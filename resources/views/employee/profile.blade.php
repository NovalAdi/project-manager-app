@extends('layout.master')

@push('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('sbadmin') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('sbadmin/vendor/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
    <div class="container-fluid">

        <div class="d-flex mb-5">
            <img class="mr-4" src="{{ asset('uploads/users') . '/' . $user->image }}" height="150" width="150"
                alt="">
            <div>
                <h1 class="h3 text-gray-800">{{ $user->username }}</h1>
                <h6>{{ $user->email }}</h6>
            </div>
        </div>

        <h4>Projects</h4>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $key => $project)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $project['name'] }}</td>
                                    <td>{{ $project['desk'] }}</td>
                                    <td>{{ $project['deadline'] }}</td>
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Decription</th>
                                <th>Project Name</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $key => $task)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $task['name'] }}</td>
                                    <td>{{ $task['desk'] }}</td>
                                    <td>{{ $projectNames[$key] }}</td>
                                    <td>{{ $task['status'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <!-- Page level plugins -->
    <script src="{{ asset('sbadmin') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('sbadmin') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('sbadmin/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Page level custom scripts -->
@endpush
