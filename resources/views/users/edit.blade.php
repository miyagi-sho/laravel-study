@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">ユーザー名を変更する</div>
                    <div class="panel-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $message)
                                    <p>{{ $message }}</p>
                                @endforeach
                            </div>
                        @endif
                        <form
                            action="{{ route('users.edit',['user' => $user->id]) }}"
                            method="POST"
                        >
                            @csrf
                            <div class="form-group">
                                <label for="name">新しいユーザー名</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       value ="{{ old('name') ?? $user->name }}" />
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection
