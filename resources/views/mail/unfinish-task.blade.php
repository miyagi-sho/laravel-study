<p>
    {{ $user->name }} さん、いつもご利用いただきありがとうございます。<br>
    翌日が締め切りになるタスクは下記の通りです。<br>
</p>
<div>
    @for ($i = 0; $i < count($folders); $i++)
        <b>{{ $folders[$i]->title }} </b><br>
        @foreach( $tasks[$i] as $task)
            {{ $task->title }} <br>
        @endforeach
        <br>
    @endfor
</div>
