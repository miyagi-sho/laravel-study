@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">タスク</div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>タイトル</th>
                        <th>状態</th>
                        <th>期限</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>
                                <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                            </td>
                            <td>{{ $task->formatted_due_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
