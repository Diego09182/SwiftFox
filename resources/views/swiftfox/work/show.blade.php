@extends('layouts.app')

    @section('content')

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    <br>

    @include('component.toolbar')

    @include('component.form.photo')

<div class="container">
    <div class="row">
        <h3 class="center-align animate__animated animate__fadeInDown">📷 作品展示</h3>
        <div class="row center">
            <a href="{{ route('photo.create', $work->id) }}" class="waves-effect waves-light btn-large brown darken-1">
                <i class="material-icons left">add</i> 發表新作品
            </a>
        </div>

        @if ($photos->isEmpty())
            <div class="center-align">
                <img src="{{ asset('images/empty_state.svg') }}" alt="No photos" class="responsive-img animate__animated animate__zoomIn" style="max-width: 250px;">
                <h4 class="grey-text text-darken-1 animate__animated animate__fadeInUp animate__delay-1s">此作品集目前沒有任何作品。</h4>
            </div>
        @else
            @foreach ($photos as $photo)
                <div class="col s12 m6 l4 animate__animated animate__fadeInUp" style="margin-bottom: 30px;">
                    <div class="card z-depth-2 hoverable" style="border-radius: 12px;">
                        <div class="card-image">
                            <img alt="photo" class="responsive-img materialboxed" style="height: 250px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px;" src="{{ asset('storage/'.$photo->path) }}">
                            <a class="btn-floating halfway-fab waves-effect waves-light brown" href="{{ route('photo.show', ['work' => $photo->work_id, 'photo' => $photo->id]) }}">
                                <i class="material-icons">search</i>
                            </a>
                        </div>
                        <div class="card-content">
                            <h5 class="brown-text text-darken-2"><i class="material-icons left">photo</i> {{ $photo->name }}</h5>
                        </div>
                        <div class="card-action">
                            <a class="waves-effect waves-light btn-small brown right" href="{{ route('photo.show', ['work' => $photo->work_id, 'photo' => $photo->id]) }}">
                                <i class="material-icons left">visibility</i>查看
                            </a>
                            @if(Auth::user()->administration == 5 || $photo->user->id == Auth::user()->id)
                                <form action="{{ route('photo.destroy', ['work' => $photo->work_id, 'photo' => $photo->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="waves-effect waves-light btn-small red darken-1 right" style="margin-right: 10px;">
                                        <i class="material-icons left">delete</i>刪除
                                    </button>
                                </form>
                            @endif
                            <div class="clearfix"></div>
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

@endsection
