@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

    <br>

    <div class="container animate__animated animate__fadeInUp">
        <h4 class="center animate__animated animate__fadeInDown">檔案標題:</h4>
        <h4 class="center animate__animated animate__fadeInUp animate__delay-1s">{{ $file->title }}</h4>
        <div class="row">
            <div class="col s12 m3 animate__animated animate__fadeInLeft animate__delay-1s">
                <div class="card center">
                    <div class="card-image">
                        @if ($file->user->avatar_filename)
                            <img class="materialboxed" src="{{ asset('storage/avatars/' . $file->user->avatar_filename) }}" alt="User Avatar">
                        @else
                            <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                        @endif
                    </div>
                    <div class="card-content">
                        <a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-tooltip="個人資料">
                            <i class="material-icons">perm_identity</i>
                        </a>
                        <br><br>
                        <h5>發布者:</h5>
                        <h5>{{ $file->user->account }}</h5>
                    </div>
                </div>
                <ul class="collapsible animate__animated animate__fadeInUp animate__delay-1s" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons">info</i>等級徽章</div>
                        <div class="collapsible-body center">
                            <div style="text-align: center; font-size: 1.8rem; display: inline-flex; align-items: center; gap: 0.6rem; justify-content: center; flex-wrap: wrap;">
                                @php $times = $file->user->times; @endphp
                                @if ($times >= 100)
                                    <span class="badge gold" style="font-size: 2.2rem;">💎</span> <span>鑽石會員</span>
                                @elseif ($times >= 50)
                                    <span class="badge silver" style="font-size: 2.2rem;">🥈</span> <span>白金會員</span>
                                @elseif ($times >= 20)
                                    <span class="badge bronze" style="font-size: 2.2rem;">🥉</span> <span>金牌會員</span>
                                @elseif ($times >= 10)
                                    <span class="badge blue" style="font-size: 2.2rem;">🔵</span> <span>青銅會員</span>
                                @else
                                    <span class="badge gray" style="font-size: 2.2rem;">⚪</span> <span>新手會員</span>
                                @endif
                            </div>
                            <br><br>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col s12 m9 animate__animated animate__fadeInRight animate__delay-2s">
                <div class="card">
                    <div class="card-content">
                        <h4>檔案描述:</h4>
                        <h4>{{ $file->content }}</h4>

                        <h4>檔案名稱:</h4>
                        <h4>
                            <a href="{{ asset('storage/' . $file->path) }}" download>
                                {{ $file->filename }}
                            </a>
                        </h4>
                        <h4>贊助連結:</h4>
                        <h4>{{ $file->donation }}</h4>
                        <div class="row">
                            <div class="col s12 right-align">
                                <p>觀看次數: {{ $file->view }}</p>
                                <p>發表時間: {{ $file->created_at }}</p>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->administration == 5 || $file->user->id == Auth::user()->id)
                        <div class="card-action right-align">
                            <form action="{{ route('file.destroy', $file->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-floating waves-effect waves-light brown tooltipped" data-tooltip="刪除">
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="modal2" class="modal">
        <div class="modal-content">
            <h4 class="center-align">個人資料</h4>
            <div class="row">
                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-image">
                            @if ($file->user->avatar_filename)
                                <img class="materialboxed" src="{{ asset('storage/avatars/' . $file->user->avatar_filename) }}" alt="User Avatar">
                            @else
                                <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                            @endif
                        </div>
                        <div class="card-content">
                            <h5 class="center">{{ $file->user->account }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col s12 m8">
                    <div class="card">
                        <div class="card-content">
                            <h5>個人簡介:</h5>
                            <h5>{{ $file->user->info }}</h5>
                            <h5>興趣: {{ $file->user->interest }}</h5>
                            <h5>社團: {{ $file->user->club }}</h5>
                            <h5>上站次數: {{ $file->user->times }}</h5>
                            <h5 class="left">等級標章:
                                @php
                                    $times = $file->user->times;
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
                                @if ($file->user->url)
                                    <h5>{{ $file->user->url }}</h5>
                                    <a href="{{ $file->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
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

@section('scripts')

@endsection
