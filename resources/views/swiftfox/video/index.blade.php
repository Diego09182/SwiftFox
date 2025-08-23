@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	<br>

	@include('component.toolbar')

	<div class="container">
        <div class="row">
            <h3 class="center-align wow animate__animated animate__fadeInUp animate__delay-1s brown-text text-darken-3">
                <b>所有影片</b>
            </h3>
            <div class="row center">
                <a href="{{ route('video.create') }}" class="waves-effect waves-light btn-large brown">
                    <i class="material-icons left">add</i>新增影片
                </a>
            </div>
            @if ($videos->isEmpty())
                <h5 class="center-align grey-text text-darken-1 wow animate__animated animate__fadeInUp animate__delay-1s">
                    目前沒有影片
                </h5>
            @else
                <div class="row center">
                    {{ $videos->links('vendor.pagination.materialize') }}
                </div>
                <div class="row">
                    @foreach ($videos as $video)
                        <div class="col s12 m6 l4 wow animate__animated animate__fadeInUp animate__delay-1s">
                            <div class="card hoverable z-depth-3">
                                <div class="card-content black-text">
                                    <h5 class="truncate"><b>標題：</b>{{ $video->title }}</h5>
                                    <h5><b>上傳者：</b>{{ $video->user->account }}</h5>
                                    <h5><b>上傳時間：</b>{{ $video->created_at->format('Y-m-d H:i') }}</h5>
                                </div>
                                <div class="card-action">
                                    <a href="{{ route('video.show', ['video' => $video->id]) }}" class="btn-small waves-effect waves-light brown right">
                                        <i class="material-icons left">visibility</i>查看
                                    </a>
                                    @if(Auth::user()->administration == 5 || $video->user->id == Auth::user()->id)
                                        <form action="{{ route('video.destroy', $video->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-small waves-effect waves-light red darken-1 right">
                                                <i class="material-icons left">delete</i>刪除
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

	<br>

	@include('component.contact')

	<br>

    @include('component.footer')

</div>

@endsection
