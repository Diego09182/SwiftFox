@extends('layouts.app')

@section('content')

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	@include('component.toolbar')

	<div class="container">
        <div class="row">
            <h3 class="center-align wow animate__animated animate__fadeInUp animate__delay-1s brown-text text-darken-2">
                <b>所有活動</b>
            </h3>
            @if ($activities->isEmpty())
                <h5 class="center-align wow animate__animated animate__fadeInUp animate__delay-1s grey-text text-darken-1">
                    目前沒有活動
                </h5>
            @else
                <div class="col s12 center-align">
                    {{ $activities->links('vendor.pagination.materialize') }}
                </div>
                @foreach ($activities as $activity)
                    <div class="col s12 m6 l4 wow animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img class="materialboxed" src="{{ asset('storage/' . $activity->path) }}" alt="活動圖片" style="max-height: 200px; object-fit: cover;">
                            </div>
                            <div class="card-content">
                                <span class="card-title brown-text text-darken-2 truncate" style="font-weight: bold;">
                                    <i class="material-icons left">event</i> {{ $activity->title }}
                                </span>
                                <h5 class="grey-text text-darken-1"><b>活動介紹：</b> {{ $activity->content }}</h5>
                                <div class="divider"></div>
                                <h5><i class="material-icons tiny">place</i> 地點：{{ $activity->location }}</h5>
                                <h5><i class="material-icons tiny">schedule</i> 時間：{{ $activity->date }}</h5>
                                @if ($activity->url)
                                    <h5>
                                        <i class="material-icons tiny">link</i> 網址：
                                        <a href="{{ $activity->url }}" target="_blank" class="blue-text text-darken-2 truncate">{{ $activity->url }}</a>
                                    </h5>
                                @endif
                                <br>
                                <div class="chip right grey lighten-3">
                                    <i class="material-icons left">today</i>
                                    {{ $activity->created_at->format('Y-m-d') }}
                                </div>
                            </div>
                            <br><br>
                            <div class="card-action">
                                @if ($activity->url)
                                    <a href="{{ $activity->url }}" target="_blank" class="waves-effect waves-light btn brown right">
                                        <i class="material-icons left">open_in_new</i> 前往
                                    </a>
                                @endif
                                @if (Auth::user()->administration == 5)
                                    <form action="{{ route('activity.destroy', $activity->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn red lighten-1 waves-effect waves-light">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </form>
                                @endif
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
