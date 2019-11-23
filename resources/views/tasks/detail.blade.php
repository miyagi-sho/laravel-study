@extends('tasks.public')

@section('author_menu')
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
@endsection

@section('back_tasks_index')
    <button type="button" class="btn btn-primary" onclick="location.href='{{ route('tasks.index', ['id' => $task->folder_id]) }}'">戻る</button>
@endsection

@section('scripts')
    @include('share.task_share.scripts')
@endsection
