@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="column col-md-8">

                <!-- 以下にタスクが表示される　-->
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $task->title }}</div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    状態：<span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                                </td>
                                <td>期限：{{ $task->formatted_due_date }}</td>
                                <td>
                                    <a href="#" class="shares">シェア</a>
                                    <form class="shares-form" action="{{ route('tasks.share', ['id' => $task->folder_id, 'task_id' => $task->id]) }}" method="POST" style="display:none;">
                                        @csrf
                                    </form>
                                </td>
                                <td>
                                    　<a href="{{ route('tasks.edit', ['id' => $task->folder_id, 'task_id' => $task->id]) }}">
                                        　　　 編集
                                        　</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary" onclick="location.href='{{ route('tasks.index', ['id' => $task->folder_id]) }}'">戻る</button>
    </div>
@endsection

@section('scripts')
    @include('share.task_share.scripts')
@endsection
