@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            @if(Storage::disk('s3')->exists($task->image_path))
                <img class="img-responsive" src="{{ Storage::disk('s3')->url($task->image_path) }}">
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">{{ $task->title }}</div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                状態：<span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                            </td>
                            <td>
                                期限：{{ $task->formatted_due_date }}
                            </td>
                            @yield('author_menu')
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">メモ</div>
                <div class="panel-body">
                    {{ $task->memo }}
                </div>
            </div>
        </div>
        @yield('back_tasks_index')
    </div>
@endsection
