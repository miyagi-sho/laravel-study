@extends('layout')

@section('content')
    <div class="column col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">検索結果</div>
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif

            @if ($search_tasks)
                @if($search_tasks->isEmpty())
                    <p>’{{ $keyword }}’に該当する検索結果は存在しません。</p>
                @else
                    <p>’{{ $keyword }}’に該当する検索結果。</p>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>タスク</th>
                            <th>フォルダ</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($search_tasks as $search_task)
                            <tr>
                                <td><a href="{{ route('tasks.detail',
                                    ['id' => $search_task->folder_id,
                                    'task_id' => $search_task->task_id])
                                    }}">{{ $search_task->task_title }}</a></td>
                                <td>{{$search_task->folder_title}}</td>
                            </tr>
                        @endforeach
                    　　</tbody>
                    </table>
                @endif
            @endif
        </div>
    </div>
@endsection
