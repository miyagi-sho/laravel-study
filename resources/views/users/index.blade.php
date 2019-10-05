@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">ユーザー</div>
                    <div class="panel-body">
                        @csrf
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                        <div class="form-group">
                            <label for="name">ユーザー名</label>
                            <p>{{ Auth::user()->name }}</p>
                        </div>
                            <a href="{{ route('users.edit', [ 'user' => $user_id ]) }}">
                                ユーザー名を編集する
                            </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection
