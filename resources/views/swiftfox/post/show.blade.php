@extends('layouts.app')

@section('content')

@include('component.navigation')

@include('component.serve.message')

@include('component.logoutbanner')

<div class="fixed-action-btn click-to-toggle">
    <a class="btn-floating btn-large red">
        <i class="large material-icons brown">menu</i>
    </a>
    <ul>
        <li>
            <a href="#modal1" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="發布留言">
                <i class="material-icons">mode_edit</i>
            </a>
        </li>
        <li>
            <a href="{{route('home.index')}}" class="btn-floating yellow tooltipped modal-trigger" data-position="top" data-tooltip="我的小屋">
                <i class="material-icons">view_quilt</i>
            </a>
        </li>
        <li>
            <a href="{{route('profile.index')}}" class="btn-floating green tooltipped modal-trigger" data-position="top" data-tooltip="個人資料">
                <i class="material-icons">perm_identity</i>
            </a>
        </li>
    </ul>
</div>

@include('component.form.comment')

@include('component.form.report')

<div id="modal2" class="modal">
    <div class="modal-content">
        <h4 class="center-align">個人資料</h4>
        <div class="row">
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        @if ($post->user->avatar_filename)
                            <img class="materialboxed" src="{{ asset('storage/avatars/' . $post->user->avatar_filename) }}" alt="User Avatar">
                        @else
                            <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                        @endif
                    </div>
                    <div class="card-content">
                        <h5 class="center">{{ $post->user->account }}</h5>
                    </div>
                </div>
            </div>
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-content">
                        <h5>個人簡介:</h5>
                        <h5>{{ $post->user->info }}</h5>
                        <h5>興趣: {{ $post->user->interest }}</h5>
                        <h5>社團: {{ $post->user->club }}</h5>
                        <h5>上站次數: {{ $post->user->times }}</h5>
                        <h5 class="left">等級標章:
                            @php
                                $times = $post->user->times;
                            @endphp
                            @if ($times >= 100)
                                <span class="badge gold" title="鑽石會員">💎 鑽石會員</span>
                            @elseif ($times >= 50)
                                <span class="badge silver" title="白金會員">🥈 白金會員</span>
                            @elseif ($times >= 20)
                                <span class="badge bronze" title="金牌會員">🥉 金牌會員</span>
                            @elseif ($times >= 10)
                                <span class="badge blue" title="青銅會員">🔵 青銅會員</span>
                            @else
                                <span class="badge gray" title="新手會員">⚪ 新手會員</span>
                            @endif
                        </h5>
                        <br><br><br>
                        <h5 class="left">個人網站:</h5>
                            @if ($post->user->url)
                                <h5>{{ $post->user->url }}</h5>
                                <a href="{{ $post->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
                            @endif
                        <br><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

<div class="container">
    <div class="row">
        <div class="col s12 m3 animate__animated animate__fadeInLeft animate__slow">
            <div class="card">
                <div class="card-image">
                    @if ($post->user->avatar_filename)
                        <img src="{{ asset('storage/avatars/' . $post->user->avatar_filename) }}" alt="User Avatar">
                    @else
                        <img src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                    @endif
                </div>
                <div class="card-content">
                    <div class="row">
                        <a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped animate__animated animate__zoomIn" data-delay="50" data-tooltip="個人資料">
                            <i class="material-icons">perm_identity</i>
                        </a>
                    </div>
                    <h5>帳號:</h5>
                    <h5 class="center">{{ $post->user->account }}</h5>
                </div>
            </div>
            <ul class="collapsible animate__animated animate__fadeInLeft animate__delay-1s" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header"><i class="material-icons">info</i>等級徽章</div>
                    <div class="collapsible-body center">
                        <div style="text-align: center; font-size: 1.8rem; display: inline-flex; align-items: center; gap: 0.6rem; justify-content: center; flex-wrap: wrap;">
                            @php
                                $times = $post->user->times;
                            @endphp
                            @if ($times >= 100)
                                <span class="badge gold" title="鑽石會員" style="font-size: 2.2rem;">💎</span> <span style="font-size: 1.6rem;">鑽石會員</span>
                            @elseif ($times >= 50)
                                <span class="badge silver" title="白金會員" style="font-size: 2.2rem;">🥈</span> <span style="font-size: 1.6rem;">白金會員</span>
                            @elseif ($times >= 20)
                                <span class="badge bronze" title="金牌會員" style="font-size: 2.2rem;">🥉</span> <span style="font-size: 1.6rem;">金牌會員</span>
                            @elseif ($times >= 10)
                                <span class="badge blue" title="青銅會員" style="font-size: 2.2rem;">🔵</span> <span style="font-size: 1.6rem;">青銅會員</span>
                            @else
                                <span class="badge gray" title="新手會員" style="font-size: 2.2rem;">⚪</span> <span style="font-size: 1.6rem;">新手會員</span>
                            @endif
                        </div>
                        <br><br>
                    </div>
                </li>
            </ul>
        </div>

        <div class="col s12 m9 right animate__animated animate__fadeInUp animate__slower">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <h3 class="center animate__animated animate__fadeInDown animate__delay-1s"><b>{{ $post->title }}</b></h3>
                    </div>
                    <div class="chip left brown animate__animated animate__zoomIn animate__delay-1s">
                        <p class="white-text">#{{ $post->tag }}</p>
                    </div>
                    <br><br>
                    <hr>
                    <h5 id="post-content"
                        class="post-content animate__animated animate__fadeIn animate__delay-2s"
                        style="line-height: 1.8; word-break: break-word; overflow-wrap: break-word;">
                        {!! $post->content !!}
                    </h5>
                    <br>
                    <div class="row">
                        <p class="right">觀看次數: {{ $post->view }}</p>
                        <br>
                        <p class="right">發文時間: {{ $post->created_at }}</p>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <p id="reaction" class="left">讚: {{ $post->like }} 噓: {{ $post->dislike }}</p>
                            <button onclick="launchConfetti()"
                                    class="btn-floating waves-effect waves-light brown right tooltipped like-button animate__animated animate__bounceIn animate__delay-3s"
                                    data-post-id="{{ $post->id }}" data-tooltip="按讚"
                                    style="margin-left:5px; margin-right:5px;">
                                <i class="material-icons">thumb_up</i>
                            </button>
                            <button
                                    class="btn-floating waves-effect waves-light brown right tooltipped dislike-button animate__animated animate__bounceIn animate__delay-3s"
                                    data-post-id="{{ $post->id }}" data-tooltip="噓他"
                                    style="margin-left:5px; margin-right:5px;">
                                <i class="material-icons">thumb_down</i>
                            </button>
                            <a href="#"
                            class="btn-floating waves-effect waves-light brown right increase-font-size tooltipped animate__animated animate__zoomIn animate__delay-3s"
                            data-tooltip="字體放大"
                            style="margin-left:5px; margin-right:5px;">
                                <i class="material-icons">zoom_in</i>
                            </a>
                            <a href="#"
                            class="btn-floating waves-effect waves-light brown right decrease-font-size tooltipped animate__animated animate__zoomIn animate__delay-3s"
                            data-tooltip="字體縮小"
                            style="margin-left:5px; margin-right:5px;">
                                <i class="material-icons">zoom_out</i>
                            </a>
                        </div>
                        <div class="row">
                            @if(Auth::user()->administration == 5 || $post->user->id == Auth::user()->id)
                            <form action="{{ route('forum.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="waves-effect waves-light btn brown right animate__animated animate__fadeInRight animate__delay-3s"
                                        style="margin-left:8px; margin-right:8px;">
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>
                            @endif
                            <a href="#modal3"
                            class="btn-floating modal-trigger waves-effect waves-light brown left tooltipped animate__animated animate__zoomIn animate__delay-3s"
                            data-tooltip="檢舉貼文"
                            style="margin-left:8px; margin-right:8px;">
                                <i class="material-icons">report_problem</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container animate__animated animate__fadeInUp animate__delay-2s">
    <ul class="collection">
        <li class="collection-item avatar">
            <img src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="評論者頭像" class="circle">
            <span class="title left">發問前先查閱相關內容</span>
            <span class="author right">發文者: 系統管理員</span>
            <br>
            <p class="right"></p>
            <br>
            <hr>
            <p class="left">記得遵守社群守則</p>
            <br><br><br>
        </li>
    </ul>
</div>

@if ($comments->isEmpty())
    <h3 class="center-align animate__animated animate__fadeInUp animate__delay-3s">目前沒有留言</h3>
@else
    {{ $comments->links('vendor.pagination.materialize') }}
@foreach ($comments as $comment)
<div class="container">
    <ul class="collection">
        <li class="collection-item avatar">
            <br>
            <img src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="評論者頭像" class="circle">
            <span class="left">{{ $comment->title }}</span>
            <span class="right">回覆者:{{ $comment->user->account }}</span>
            <br>
            <p class="right">回覆時間:{{ $comment->created_at }}</p>
            <br>
            <form action="{{ route('comment.destroy', ['post' => $post->id, 'comment' => $comment->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="刪除評論">
                    <i class="material-icons">delete</i>
                </button>
            </form>
            <br><br>
            <hr>
            <p class="left">{{ $comment->content }}</p>
            <br><br><br>
        </li>
    </ul>
</div>
@endforeach
@endif

<br>

@if ($relatedPosts->isNotEmpty())
    <div class="container animate__animated animate__fadeInUp animate__delay-4s">
        <div class="section">
            <h3 class="center-align">推薦貼文</h3>
            <div class="row">
                @foreach ($relatedPosts as $post)
                    <div class="col s12 m4">
                        <div class="card hoverable center" id="post">
                            <div class="card-content">
                                <h5 class="truncate"><b>主題: {{ $post->title }}</b></h5>
                                <br>
                                <div class="chip left brown">
                                    <p class="white-text">#{{ $post->tag }}</p>
                                </div>
                                <br>
                                <p class="right">作者：{{ $post->user->account ?? '未知' }}</p>
                                <br><br>
                                <div class="row">
                                    <p class="left">讚: {{ $post->like }}</p>
                                    <p class="left">噓: {{ $post->dislike }}</p>
                                </div>
                                <div class="row">
                                    <p class="left">觀看數: {{ $post->view }}</p>
                                    <p class="right">{{ $post->created_at->format('Y-m-d') }}</p>
                                </div>
                                <a class="waves-effect waves-light btn right brown" href="{{ route('forum.show', ['post' => $post->id]) }}">查看</a>
                                <br>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<br>

@include('component.footer')

@endsection

@section('scripts')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.like-button').on('click', function() {
        const postId = $(this).data('post-id');
        $.ajax({
            url: "{{ route('forum.like', ['post' => 'postId']) }}".replace('postId', postId)
            , type: 'POST'
            , success: function(response) {
                $('#reaction').html('讚: ' + response.like + ' 噓: ' + response.dislike);
            }
            , error: function(xhr) {
                if (xhr.status === 403) {
                    M.toast({html: '已經評價過了'});
                }
            }
        });
    });

    $('.dislike-button').on('click', function() {
        const postId = $(this).data('post-id');
        $.ajax({
            url: "{{ route('forum.dislike', ['post' => 'postId']) }}".replace('postId', postId)
            , type: 'POST'
            , success: function(response) {
                $('#reaction').html('讚: ' + response.like + ' 噓: ' + response.dislike);
            }
            , error: function(xhr) {
                if (xhr.status === 403) {
                    M.toast({html: '已經評價過了'});
                }
            }
        });
    });

    $('.decrease-font-size').on('click', function(event) {
        event.preventDefault();
        let currentSize = parseInt($('#post-content').css('font-size'));
        if (currentSize > 20) {
            $('#post-content').css('font-size', (currentSize - 5) + 'px');
        }
    });

    $('.increase-font-size').on('click', function(event) {
        event.preventDefault();
        let currentSize = parseInt($('#post-content').css('font-size'));
        if (currentSize < 35) {
            $('#post-content').css('font-size', (currentSize + 5) + 'px');
        }
    });

    function launchConfetti() {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 },
        });
    }

</script>

@endsection
