@extends('layout')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $message)
                <p>{{ $message }}</p>
            @endforeach
        </div>
    @endif

    @if ($search_tasks)
        @if($search_tasks->isEmpty())
            <h1>’{{ $keyword }}’に該当する検索結果は存在しません。</h1>
        @endif
        @foreach ($search_tasks as $search_task)
            {{ $search_task->title }}
        @endforeach
    @endif
@endsection
