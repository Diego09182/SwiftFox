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
            <h3 class="center-align animate__animated animate__fadeInDown">🎨 所有作品</h3>

            <div class="row center">
                <a href="{{ route('work.create') }}" class="waves-effect waves-light btn-large amber darken-3">
                    <i class="material-icons left">add_circle_outline</i> 發表新作品
                </a>
            </div>

            @if ($works->isEmpty())
                <div class="center-align">
                    <img src="{{ asset('images/empty_state.svg') }}" alt="No works" style="width: 200px;" class="animate__animated animate__fadeInDown" />
                    <h4 class="grey-text text-darken-1 animate__animated animate__fadeInUp animate__delay-1s">目前沒有作品集</h4>
                </div>
            @else
                {{ $works->links('vendor.pagination.materialize') }}

                @foreach ($works as $work)
                    <div class="col s12 m6 l4 animate__animated animate__fadeInUp animate__delay-2s" style="margin-bottom: 30px;">
                        <div class="card hoverable center z-depth-3" id="work" style="border-radius: 16px;">
                            <div class="card-content">
                                <h5 class="truncate brown-text text-darken-2" style="font-weight: bold;">
                                    <i class="material-icons left">folder</i> 主題：{{ $work->name }}
                                </h5>
                                <div class="divider"></div>
                                <p class="right grey-text">作者：{{ $work->user->account }}</p>
                                <br><br>
                                <p class="right grey-text">{{ $work->created_at->format('Y-m-d') }}</p>
                                <br><br>
                                <a class="waves-effect waves-light btn-small right brown lighten-1" href="{{ route('work.show', ['work' => $work->id]) }}">
                                    <i class="material-icons left">visibility</i>查看
                                </a>

                                @if(Auth::user()->administration == 5 || $work->user->id == Auth::user()->id)
                                    <form action="{{ route('work.destroy', $work->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="waves-effect waves-light btn-small left red darken-1">
                                            <i class="material-icons left">delete</i>刪除
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <br><br>
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
