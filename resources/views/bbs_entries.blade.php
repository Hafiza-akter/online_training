<!DOCTYPE html>

<head>
    <!-- Laravel EchoではCSRFトークンを利用するのでmetaタグを追加する必要がある -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- スタイルシートの読み込み -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <a href="{{ route('home') }}">ホーム</a>
    <p>USER: {{ $user->name . ' (' . $user->email . ')' }}</p>
    <form method="POST" action="{{ route('bbs') }}">
        @csrf
        <input type="number" name="count_per_set" value={{ $user->count_per_set }} min="1" max="20">
        <button class="btn btn-primary" type="submit">セットを開始する</button>
    </form>

    <!-- appが入っている必要がある -->
    <div id='app'>
        <bbs-entries user_id = {{ $user->id }}></bbs-entries>
    </div>

    <!-- bodyの終わりに入れる -->
    <script src="{{ asset('js/app.js')}}" defer></script>
</body>