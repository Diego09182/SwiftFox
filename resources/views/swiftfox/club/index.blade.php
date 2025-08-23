@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	@include('component.toolbar')

    <div class="container">
        <div class="row">
            @foreach ($clubs as $club)
                <div class="col s12 wow animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="card horizontal" id="post">
                        @if ($club->path)
                            <div class="card-image">
                                <img class="materialboxed" src="{{ asset('storage/' . $club->path) }}" alt="社團圖片" style="width: 250px; height: 100%; object-fit: cover;">
                            </div>
                        @endif
                        <div class="card-stacked">
                            <div class="card-content">
                                <h5 class="truncate">社團名稱: {{ $club->title }}</h5>
                                <div class="chip brown white-text">#{{ $club->tag }}</div>
                                <h5 class="mt-2"><strong>社團介紹:</strong> {{ $club->content }}</h5>
                                <h5>社長: {{ $club->director }}</h5>
                                <h5>副社長: {{ $club->vice_director }}</h5>
                                <h5>指導教師: {{ $club->teacher }}</h5>
                                <h5 class="right grey-text text-darken-1">{{ $club->created_at }}</h5>
                            </div>
                            @if(Auth::user()->administration == 5)
                                <div class="card-action right-align">
                                    <form action="{{ route('club.destroy', $club->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-flat waves-effect waves-red">
                                            <i class="material-icons red-text">delete</i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col s12 center-align">
            {{ $clubs->links('vendor.pagination.materialize') }}
        </div>
    </div>

    <br>

	<br>

	@include('component.contact')

	<br>

    @include('component.footer')

</div>

@endsection
