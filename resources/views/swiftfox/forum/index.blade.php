@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

    <div class="container">
        <div class="row">
            <form action="{{ route('forum.search') }}" method="GET">
                <div class="input-field col m12">
                    <i class="material-icons prefix">search</i>
                    <input name="search" id="icon_prefix" type="text" class="validate">
                    <label for="icon_prefix">Search</label>
                </div>
            </form>
        </div>
        <div class="row">
            <form action="{{ route('forum.filter') }}" method="GET">
                <div class="input-field col m4">
                    <select name="filter">
                        <option value="" disabled selected>熱度篩選</option>
                        <option value="觀看次數">觀看次數</option>
                        <option value="喜歡次數">喜歡次數</option>
                    </select>
                    <label>熱度篩選</label>
                </div>
                <div class="input-field">
                    <button type="submit" class="btn waves-effect waves-light brown right">貼文篩選</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="row center">
                <a href="{{ route('forum.create') }}" class="waves-effect waves-light btn brown"><i class="material-icons left">mode_edit</i>貼文發表</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <h3 class="center-align">🔥 本週熱門貼文</h3>
            <br>
            @if ($top_posts->isEmpty())
            <h3 class="center-align">目前沒有熱門貼文</h3>
            @else
            @foreach ($top_posts as $post)
            <div class="col s12 m4">
                <div class="card hoverable center" id="post">
                    <div class="card-content">
                        <h5 class="truncate"><b>主題: {{ $post->title }}</b></h5>
                        <br>
                        <div class="chip left brown">
                            <p class="white-text">#{{ $post->tag }}</p>
                        </div>
                        <br>
                        <p class="right">作者：{{ $post->user->account }}</p>
                        <br><br>
                        <div class="row">
                            <p class="left">讚:{{ $post->like }}</p>
                            <p class="left">噓:{{ $post->dislike }}</p>
                        </div>
                        <div class="row">
                            <p class="left">觀看數:{{ $post->view }}</p>
                            <p class="right">{{ $post->created_at }}</p>
                        </div>
                        <a class="waves-effect waves-light btn right brown" href="{{ route('forum.show', ['post' => $post->id]) }}">查看</a>
                        <br>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

    <div class="container">
        <div class="row">
            <h3 class="center-align">所有貼文</h3>
            <br>
            @if ($posts->isEmpty())
             <h3 class="center-align">目前沒有貼文</h3>
            @else
                {{ $posts->links('vendor.pagination.materialize') }}
                @foreach ($posts as $post)
                    <div class="col s12 m4">
                        <div class="card hoverable center" id="post">
                            <div class="card-content">
                                <h5 class="truncate"><b>主題: {{ $post->title }}</b></h5>
                                <br>
                                <div class="chip left brown">
                                    <p class="white-text">#{{ $post->tag }}</p>
                                </div>
                                <br>
                                <p class="right">作者：{{ $post->user->account }}</p>
                                <br><br>
                                <div class="row">
                                    <p class="left">讚:{{ $post->like }}</p>
                                    <p class="left">噓:{{ $post->dislike }}</p>
                                </div>
                                <div class="row">
                                    <p class="left">觀看數:{{ $post->view }}</p>
                                    <p class="right">{{ $post->created_at }}</p>
                                </div>
                                <a class="waves-effect waves-light btn right brown" href="{{ route('forum.show', ['post' => $post->id]) }}">查看</a>
                                <br>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <br>

    @include('component.contact')

    <br>

    @include('component.footer')

</div>

@endsection
