<p>
    {{ $user->name }} さん、いつもご利用いただきありがとうございます。<br>
    翌日が締め切りになるタスクは下記の通りです。<br>
</p>
<div>
    @for ($i = 0; $i < count($folder); $i++)
        {{ $folder[$i]->title }} <br>
        @foreach( $task[$i] as $t)
            {{ $t->title }} <br>
        @endforeach
        <br>
    @endfor
</div>
