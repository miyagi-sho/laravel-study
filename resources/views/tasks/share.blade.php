@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">公開されているURL</div>
                    <div class="panel-body">
                        <a href="{{ route('tasks.public', ['share' => $task->share]) }}">
                            {{ route('tasks.public', ['share' => $task->share]) }}
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection
