@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <br>

    <div class="fixed-action-btn click-to-toggle">
        <a class="btn-floating btn-large red">
            <i class="large material-icons brown">menu</i>
        </a>
        <ul>
            <li>
                <a href="{{ route('home.index') }}" class="btn-floating yellow tooltipped modal-trigger" data-position="top" data-tooltip="我的小屋">
                    <i class="material-icons">view_quilt</i>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.index') }}" class="btn-floating green tooltipped modal-trigger" data-position="top" data-tooltip="個人資料">
                    <i class="material-icons">perm_identity</i>
                </a>
            </li>
        </ul>
    </div>

    <div class="container">
        <h4 class="center">檔案標題:</h4>
        <h4 class="center">{{ $file->title }}</h4>
        <div class="row">
            <div class="col s12 m3">
                <div class="center">
                    <div class="card">
                        <div class="card-image">
                            <img class="materialboxed" src="{{ asset('storage/avatars/' . $user->avatar_filename) }}" alt="User Avatar">
                        </div>
                        <div class="card-content">
                            <a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="個人資料"><i class="material-icons">perm_identity</i></a>
                            <br><br>
                            <h5>發布者:</h5>
                            <h5>{{ $file->user->account }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m9">
                <div class="card">
                    <div class="card-content">
                        <h4>檔案描述:</h4>
                        <h4>{{ $file->content }}</h4>
                        <h4>檔案名稱:</h4>
                        <h4><a href="{{ asset('storage/' . $file->path) }}" download>{{ $file->filename }}</a></h4>
                        <div class="card-action">
                            @if(Auth::user()->administration == 5 || $file->user->id == Auth::user()->id)
                            <form action="{{ route('file.destroy', $file->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-floating waves-effect waves-light brown right">
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>
                            @endif
                        </div>
                        <br>
                    </div>
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
                            <img class="materialboxed" src="{{ asset('storage/avatars/' . $user->avatar_filename) }}" alt="User Avatar">
                        </div>
                        <div class="card-content">
                            <h5>使用者: {{ $file->user->account }}</h5>
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
                            <h5>個人網站:</h5>
                            @if ($file->user->url)
                            <h5>{{ $file->user->url }}</h5>
                            <a href="{{ $file->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
                            @endif
                            <br>
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
