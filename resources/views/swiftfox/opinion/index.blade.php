@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	@include('component.toolbar')

	<div class="container">
        <div class="row">
            <h3 class="center-align wow animate__animated animate__fadeInUp animate__delay-2s">
                所有投票
            </h3>
            <div class="row center">
                <a href="{{ route('opinion.create') }}" class="waves-effect waves-light btn-large brown darken-2 z-depth-2">
                    <i class="material-icons left">mode_edit</i>發表
                </a>
            </div>
            @if ($opinions->isEmpty())
                <h4 class="center-align grey-text text-darken-1 wow animate__animated animate__fadeInUp animate__delay-2s">
                    目前沒有投票事項
                </h4>
            @else
                <div class="row center">
                    {{ $opinions->links('vendor.pagination.materialize') }}
                </div>
                @foreach ($opinions as $opinion)
                    <div class="col s12 m6 l4">
                        <div class="card hoverable wow animate__animated animate__fadeInUp animate__delay-2s z-depth-3">
                            <div class="card-content">
                                <h5 class="brown-text text-darken-3 truncate">
                                    <b>主題：</b>{{ $opinion->title }}
                                </h5>
                                @if ($opinion->status == 1)
                                    <div class="chip green white-text z-depth-1">#進行中</div>
                                @else
                                    <div class="chip brown white-text z-depth-1">#已結束</div>
                                @endif
                                <div class="divider" style="margin: 10px 0;"></div>
                                <h5 class="grey-text text-darken-1"><b>發布者：</b>{{ $opinion->user->account }}</h5>
                                <h5 class="grey-text text-darken-1"><b>創建時間：</b>{{ $opinion->created_at }}</h5>
                                <h5 class="grey-text text-darken-1"><b>結束時間：</b>{{ $opinion->finished_time }}</h5>
                                <div class="right-align" style="margin-top: 10px;">
                                    <a href="{{ route('opinion.show', ['opinion' => $opinion->id]) }}" class="btn-small brown waves-effect">
                                        查看
                                    </a>
                                </div>
                            </div>
                            <div class="progress" style="margin: 0;">
                                <div class="determinate {{ $opinion->status == 1 ? 'green' : 'brown' }}" style="width: 100%"></div>
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
