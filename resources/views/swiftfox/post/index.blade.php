@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

    @include('component.searchpanel')

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
                                    <div class="col s6 left-align">
                                        👍 {{ $post->like }}　👎 {{ $post->dislike }}
                                    </div>
                                    <div class="col s6 right-align">
                                        觀看次數: {{ $post->view }}
                                    </div>
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
                                    <div class="col s6 left-align">
                                        👍 {{ $post->like }}　👎 {{ $post->dislike }}
                                    </div>
                                    <div class="col s6 right-align">
                                        觀看次數: {{ $post->view }}
                                    </div>
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
