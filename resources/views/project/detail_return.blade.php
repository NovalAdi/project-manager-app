@extends('layout.master')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Detail to "{{ $task->name }}" return's</h1>
            <form
                action="{{ route('project.return.task.delete', ['idTask' => $task->id, 'idProject' => $project['id']]) }}"
                method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to cancel this return')">Cancel this Return</button>
            </form>
        </div>

        <h6 class="mb-2">Return at : {{ $notif->created_at }}</h6>
        <a href="{{ route('project.show', $project->id) }}" class="btn btn-primary mb-5">Back</a>
        <h6>{{ $notif->message }}</h6>

    </div>
@endsection
