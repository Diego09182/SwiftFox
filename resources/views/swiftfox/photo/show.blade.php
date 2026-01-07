@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <br>

    @include('component.toolbar')

    <div class="container">
        <h3 class="center animate__animated animate__fadeInDown">作品名稱:</h3>
        <h3 class="center animate__animated animate__fadeInDown animate__delay-1s">{{ $photo->name }}</h3>
        <div class="row">
            <div class="col s12 m3">
                <div class="center">
                    <div class="card animate__animated animate__zoomIn animate__delay-1s">
                        <div class="card-image">
                            @if ($photo->user->avatar_filename)
                                <img class="materialboxed" src="{{ asset('storage/avatars/' . $photo->user->avatar_filename) }}" alt="User Avatar">
                            @else
                                <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                            @endif
                        </div>
                        <div class="card-content">
                            <a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-tooltip="個人資料">
                                <i class="material-icons">perm_identity</i>
                            </a>
                            <br><br>
                            <h5>發文者:</h5>
                            <h5>{{ $photo->user->account }}</h5>
                        </div>
                    </div>
                    <ul class="collapsible animate__animated animate__fadeInLeft animate__delay-2s">
                        <li>
                            <div class="collapsible-header">
                                <i class="material-icons">info</i>等級徽章
                            </div>
                            <div class="collapsible-body center">
                                @php $times = $photo->user->times; @endphp
                                <div style="font-size: 1.8rem; display: inline-flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 0.6rem;">
                                    @if ($times >= 100)
                                        <span title="鑽石會員">💎 鑽石會員</span>
                                    @elseif ($times >= 50)
                                        <span title="白金會員">🥈 白金會員</span>
                                    @elseif ($times >= 20)
                                        <span title="金牌會員">🥉 金牌會員</span>
                                    @elseif ($times >= 10)
                                        <span title="青銅會員">🔵 青銅會員</span>
                                    @else
                                        <span title="新手會員">⚪ 新手會員</span>
                                    @endif
                                </div>
                                <br><br>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col s12 m9">
                <div class="card horizontal animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="card-image">
                        <img class="responsive-img materialboxed" src="{{ asset('storage/images/' . $photo->filename) }}" alt="Photo">
                    </div>
                    <div class="card-stacked">
                        <div class="card-content">
                            <h4>作品描述:</h4>
                            <h5>{{ $photo->content }}</h5>
                        </div>
                        <div class="card-action">
                            @if(Auth::user()->administration == 5 || $photo->user->id == Auth::user()->id)
                                <form action="{{ route('photo.destroy', ['work' => $photo->work_id, 'photo' => $photo->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-floating waves-effect waves-light brown right tooltipped" data-tooltip="刪除作品">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <h3 class="center">其他作品:</h3>
            @foreach ($photos as $photo)
                <div class="col s12 m6 l4">
                    <div class="card hoverable z-depth-2" style="border-radius: 12px;">
                        <div class="card-image">
                            <img class="responsive-img" src="{{ asset('storage/'.$photo->path) }}" alt="photo">
                            <a class="btn-floating halfway-fab waves-effect waves-light brown" href="{{ route('photo.show', ['work' => $photo->work_id, 'photo' => $photo->id]) }}">
                                <i class="material-icons">search</i>
                            </a>
                        </div>
                        <div class="card-content">
                            <h6 class="truncate">作品名稱：{{ $photo->name }}</h6>
                        </div>
                        <div class="card-action">
                            @if(Auth::user()->administration == 5 || $photo->user->id == Auth::user()->id)
                                <form action="{{ route('photo.destroy', ['work' => $photo->work_id, 'photo' => $photo->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="waves-effect waves-light btn-small red darken-1 right">
                                        刪除
                                    </button>
                                </form>
                            @endif
                        </div>
                        <br><br>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="modal2" class="modal">
        <div class="modal-content">
            <h4 class="center-align">個人資料</h4>
            <div class="row">
                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-image">
                            @if ($photo->user->avatar_filename)
                                <img class="materialboxed" src="{{ asset('storage/avatars/' . $photo->user->avatar_filename) }}" alt="User Avatar">
                            @else
                                <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                            @endif
                        </div>
                        <div class="card-content">
                            <h5 class="center">{{ $photo->user->account }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col s12 m8">
                    <div class="card">
                        <div class="card-content">
                            <h5>個人簡介:</h5>
                            <h5>{{ $photo->user->info }}</h5>
                            <h5>興趣: {{ $photo->user->interest }}</h5>
                            <h5>社團: {{ $photo->user->club }}</h5>
                            <h5>上站次數: {{ $photo->user->times }}</h5>
                            <h5 class="left">等級標章:
                                @php
                                    $times = $photo->user->times;
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
                                @if ($photo->user->url)
                                    <h5>{{ $photo->user->url }}</h5>
                                    <a href="{{ $photo->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
                                @endif
                            <br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    @include('component.contact')

    <br>

    @include('component.footer')

</div>

@endsection
