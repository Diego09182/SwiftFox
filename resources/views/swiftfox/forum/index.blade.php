@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

    <div class="container">
            <div class="card-panel z-depth-2">
                    <div class="row">
                        <form action="{{ route('forum.search') }}" method="GET" class="col s12 m8">
                            <div class="input-field">
                                <i class="material-icons prefix">search</i>
                                <input name="search" id="icon_prefix" type="text" class="validate">
                                <label for="icon_prefix">搜尋貼文</label>
                            </div>
                        </form>

                        <form action="{{ route('forum.filter') }}" method="GET" class="col s12 m4">
                            <div class="input-field">
                                <select name="filter">
                                    <option value="" disabled selected>熱度篩選</option>
                                    <option value="觀看次數">觀看次數</option>
                                    <option value="喜歡次數">喜歡次數</option>
                                </select>
                                <label>篩選條件</label>
                            </div>
                            <div class="right-align">
                                <button type="submit" class="btn brown waves-effect waves-light">
                                    <i class="material-icons left">filter_list</i>篩選
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row center">
                    <a href="{{ route('forum.create') }}" class="btn-large brown waves-effect waves-light z-depth-2">
                        <i class="material-icons left">mode_edit</i>貼文發表
                    </a>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <h4 class="center-align animate__animated animate__fadeInDown animate__delay-2s">🔥 本週熱門貼文</h4>
                    @if ($top_posts->isEmpty())
                        <h5 class="center-align grey-text">目前沒有熱門貼文</h5>
                    @else
                        @foreach ($top_posts as $post)
                            <div class="col s12 m4 animate__animated animate__fadeInUp animate__delay-2s">
                                @include('components.post-card', ['post' => $post])
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

                <div class="container">
                        <div class="row">
                            <h4 class="center-align animate__animated animate__fadeInUp animate__delay-3s">📜 所有貼文</h4>
                            @if ($posts->isEmpty())
                                <h5 class="center-align grey-text">目前沒有貼文</h5>
                            @else
                                {{ $posts->links('vendor.pagination.materialize') }}
                                @foreach ($posts as $post)
                                    <div class="col s12 m4 animate__animated animate__fadeInUp animate__delay-3s">
                                        <div class="card hoverable z-depth-2">
                        <div class="card-content">
                            <h5 class="truncate brown-text"><b>主題: {{ $post->title }}</b></h5>
                            <div class="chip brown white-text left" style="margin-top: 10px;">
                                #{{ $post->tag }}
                            </div>
                            <p class="right grey-text text-darken-1">作者：{{ $post->user->account }}</p>
                            <div class="clearfix"></div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col s6 left-align">👍 {{ $post->like }}　👎 {{ $post->dislike }}</div>
                                <div class="col s6 right-align">觀看次數: {{ $post->view }}</div>
                            </div>
                            <div class="right-align grey-text text-darken-1">
                                {{ $post->created_at->format('Y-m-d H:i') }}
                            </div>
                            <div class="right-align" style="margin-top: 10px;">
                                <a href="{{ route('forum.show', ['post' => $post->id]) }}" class="btn brown waves-effect">
                                    <i class="material-icons left">visibility</i>查看
                                </a>
                            </div>
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
