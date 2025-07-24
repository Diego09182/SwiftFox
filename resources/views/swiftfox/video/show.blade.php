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
				<a href="{{route('home.index')}}"class="btn-floating yellow tooltipped modal-trigger" data-position="top" data-tooltip="我的小屋">
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

	<div class="container">
		<h4 class="center">影片標題:</h4>
		<h4 class="center">{{ $video->title }}</h4>
		<div class="row">
			<div class="col s12 m3">
				<div class="center">
					<div class="card">
						<div class="card-image">
							@if ($video->user->avatar_filename)
                            <img class="materialboxed" src="{{ asset('storage/avatars/' . $video->user->avatar_filename) }}" alt="User Avatar">
                            @else
                            <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                            @endif
						</div>
						<div class="card-content">
							<a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="個人資料"><i class="material-icons">perm_identity</i></a>
							<br><br>
							<h5>發布者:</h5>
							<h5>{{ $video->user->account }}</h5>
						</div>
					</div>
                    <ul class="collapsible animate__animated animate__fadeInLeft animate__delay-1s" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header"><i class="material-icons">info</i>等級徽章</div>
                            <div class="collapsible-body center">
                                <div style="text-align: center; font-size: 1.8rem; display: inline-flex; align-items: center; gap: 0.6rem; justify-content: center; flex-wrap: wrap;">
                                    @php
                                        $times = $video->user->times;
                                    @endphp
                                    @if ($times >= 100)
                                        <span class="badge gold" title="鑽石會員" style="font-size: 2.2rem;">💎</span> <span style="font-size: 1.6rem;">鑽石會員</span>
                                    @elseif ($times >= 50)
                                        <span class="badge silver" title="白金會員" style="font-size: 2.2rem;">🥈</span> <span style="font-size: 1.6rem;">白金會員</span>
                                    @elseif ($times >= 20)
                                        <span class="badge bronze" title="金牌會員" style="font-size: 2.2rem;">🥉</span> <span style="font-size: 1.6rem;">金牌會員</span>
                                    @elseif ($times >= 10)
                                        <span class="badge blue" title="青銅會員" style="font-size: 2.2rem;">🔵</span> <span style="font-size: 1.6rem;">青銅會員</span>
                                    @else
                                        <span class="badge gray" title="新手會員" style="font-size: 2.2rem;">⚪</span> <span style="font-size: 1.6rem;">新手會員</span>
                                    @endif
                                </div>
                                <br><br>
                            </div>
                        </li>
                    </ul>
				</div>
			</div>
			<div class="col s12 m9">
				<div class="card">
					<div class="card-content">
						<video controls class="responsive-video">
							<source src="{{ asset('storage/videos/' . $video->filename) }}" type="video/mp4">
						</video>
						<h4>影片描述:</h4>
						<h4>{{ $video->content }}</h4>
						<div class="card-action">
							@if(Auth::user()->administration == 5 || $video->user->id == Auth::user()->id)
								<form action="{{ route('video.destroy', $video->id) }}" method="POST">
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
							@if ($video->user->avatar_filename)
                            <img class="materialboxed" src="{{ asset('storage/avatars/' . $video->user->avatar_filename) }}" alt="User Avatar">
                            @else
                            <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                            @endif
						</div>
						<div class="card-content">
							<h5>使用者: {{ $video->user->account }}</h5>
						</div>
					</div>
				</div>
				<div class="col s12 m8">
					<div class="card">
						<div class="card-content">
							<h5>個人簡介:</h5>
							<h5>{{ $video->user->info }}</h5>
							<h5>興趣: {{ $video->user->interest }}</h5>
							<h5>社團: {{ $video->user->club }}</h5>
							<h5>上站次數: {{ $video->user->times }}</h5>
							<h5>個人網站:</h5>
							@if ($video->user->url)
								<h5>{{ $video->user->url }}</h5>
								<a href="{{ $video->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
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
