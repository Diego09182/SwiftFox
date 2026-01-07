@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

    <div class="container animate__animated animate__fadeInUp animate__delay-1s">
        <div class="section">
            <h4 class="center-align">通知中心</h4>
            <h4 class="center-align">顯示官方的通知資訊</h4>
            <div class="divider"></div>
        </div>
        <div class="right-align mb-3">
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button class="btn waves-effect waves-light red lighten-1 z-depth-1" type="submit">
                    <i class="material-icons left">done_all</i> 標記全部為已讀
                </button>
            </form>
        </div>
        <div class="center-align">
            {{ $notifications->links('vendor.pagination.materialize') }}
        </div>
        @forelse ($notifications as $notification)
            <div class="card z-depth-1 @if($notification->read_at === null) red lighten-5 @else white @endif">
                <div class="card-content">
                    <span class="card-title">
                        <b>
                            <i class="material-icons left">{{ $notification->read_at === null ? 'notifications_active' : 'notifications_none' }}</i>
                            {{ $notification->data['title'] }}
                        </b>
                    </span>
                    <h5>
                        <strong>資源類型：</strong> {{ $notification->data['resource_type'] }}
                    </h5>
                    <h5>
                        <strong>原因：</strong> {{ $notification->data['reason'] }}
                    </h5>
                    <h5 class="grey-text text-darken-1 right" style="margin-top: 10px;">
                        <i class="material-icons tiny">access_time</i> 發送時間：{{ $notification->created_at->diffForHumans() }}
                    </h5>
                    <br><br>
                </div>
            </div>
        @empty
            <div class="card-panel grey lighten-4 center-align">
                <i class="material-icons large grey-text">notifications_off</i>
                <h6 class="grey-text">沒有任何通知</h6>
            </div>
        @endforelse
        <div class="center-align">
            {{ $notifications->links('vendor.pagination.materialize') }}
        </div>
    </div>

    <br>

    @include('component.contact')

    <br>

    @include('component.footer')

</div>

@endsection
