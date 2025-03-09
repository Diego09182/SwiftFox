@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <div class="fixed-action-btn click-to-toggle">
        <a class="btn-floating btn-large red">
            <i class="large material-icons brown">menu</i>
        </a>
        <ul>
            <li>
                <a href="#modal1" class="btn-floating red tooltipped modal-trigger" data-position="top" data-tooltip="發布日記">
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

    @include('component.form.note')

    <div id="modal2" class="modal">
        <div class="modal-content">
            <h4 class="center-align">個人資料</h4>
            <div class="row">
                <div class="col s12 m4">
                    <div class="card">
                        @if ($note->user->avatar_filename)
                        <img class="materialboxed" src="{{ asset('storage/avatars/' . $note->user->avatar_filename) }}" alt="User Avatar">
                        @else
                        <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                        @endif
                        <div class="card-content">
                            <h5>使用者: {{ $note->user->account }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col s12 m8">
                    <div class="card">
                        <div class="card-content">
                            <h5>個人簡介:</h5>
                            <h5>{{ $note->user->info }}</h5>
                            <h5>興趣: {{ $note->user->interest }}</h5>
                            <h5>社團: {{ $note->user->club }}</h5>
                            <h5>上站次數: {{ $note->user->times }}</h5>
                            <h5>個人網站:</h5>
                            @if ($note->user->url)
                            <h5>{{ $note->user->url }}</h5>
                            <a href="{{ $note->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
                            @endif
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="container">
        <div class="row">
            <div class="col s12 m3">
                <div class="center">
                    <div class="card">
                        <div class="card-image">
                            @if ($note->user->avatar_filename)
                            <img class="materialboxed" src="{{ asset('storage/avatars/' . $note->user->avatar_filename) }}" alt="User Avatar">
                            @else
                            <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                            @endif
                        </div>
                        <div class="card-content">
                            <a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="個人資料"><i class="material-icons">perm_identity</i></a>
                            <br><br>
                            <h5>發文者:</h5>
                            <h5>{{ $note->user->account }}</h5>
                        </div>
                    </div>
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header"><i class="material-icons">info</i>自我介紹</div>
                            <div class="collapsible-body">
                                <p>{{ $note->user->info }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col s12 m9 right">
                <div class="card">
                    <br><br>
                    <div class="card-content center">
                        <h3>{{ $note->title }}</h4>
                            <h5>{!! $note->content !!}</h5>
                            <br>
                            <div class="chip left brown">
                                <p class="white-text">#{{ $note->tag }}</p>
                            </div>
                            <p class="right">發文時間: {{ $note->created_at }}</p>
                            <br><br>
                            <div class="card-action">
                                <div class="row">
                                    @if(Auth::user()->administration == 5 || $note->user->id == Auth::user()->id)
                                    <form action="{{ route('note.destroy', $note->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="waves-effect waves-light btn brown right">
                                            刪除
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    @include('component.footer')

</div>

@endsection
