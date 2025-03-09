@extends('layouts.app')

@section('content')
	
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

	<div id="modal2" class="modal">
		<div class="modal-content">
			<h4 class="center-align">個人資料</h4>
			<div class="row">
				<div class="col s12 m4">
					<div class="card">
						<div class="card-image">
							@if ($opinion->user->avatar_filename)
                            <img class="materialboxed" src="{{ asset('storage/avatars/' . $opinion->user->avatar_filename) }}" alt="User Avatar">
                            @else
                            <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                            @endif
						</div>
						<div class="card-content">
							<h5>使用者: {{ $opinion->user->account }}</h5>
						</div>
					</div>
				</div>
				<div class="col s12 m8">
					<div class="card">
						<div class="card-content">
							<h5>個人簡介:</h5>
							<h5>{{ $opinion->user->info }}</h5>
							<h5>興趣: {{ $opinion->user->interest }}</h5>
							<h5>社團: {{ $opinion->user->club }}</h5>
							<h5>上站次數: {{ $opinion->user->times }}</h5>
							<h5>個人網站:</h5>
							@if ($opinion->user->url)
								<h5>{{ $opinion->user->url }}</h5>
								<a href="{{ $opinion->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
							@endif
							<br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col s12 m3">
				<div class="center">
					<div class="card">
						<div class="card-image">
							@if ($opinion->user->avatar_filename)
                            <img class="materialboxed" src="{{ asset('storage/avatars/' . $opinion->user->avatar_filename) }}" alt="User Avatar">
                            @else
                            <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
                            @endif
						</div>
						<div class="card-content">
							<a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="個人資料"><i class="material-icons">perm_identity</i></a>
							<br><br>
							<h5>發布者:</h5>
							<h5>{{ $opinion->user->account }}</h5>
						</div>
					</div>
					<ul class="collapsible" data-collapsible="accordion">
						<li>
							<div class="collapsible-header"><i class="material-icons">info</i>自我介紹</div>
							<div class="collapsible-body"><p>{{ $opinion->user->info }}</p></div>
						</li>
					</ul>
				</div>
			</div>
			<div class="col s12 m9 right">
				<div class="card">
					<br><br>
					<div class="card-content center">
						<h3>{{ $opinion->title }}</h4>
						<h5 :style="{ 'word-wrap': 'break-word' }">{!! $opinion->content !!}</h5>
						<br>
						<p class="right">創建時間: {{ $opinion->created_at }}</p>
						<br>
						<p class="right">結束時間: {{ $opinion->finished_time }}</p>
						<br><br>
						@if ($opinion->status == 1)
							<div class="chip left green">
								<p class="black-text">#進行中</p>
							</div>
						@else
							<div class="chip left brown">
								<p class="white-text">#已結束</p>
							</div>
						@endif
						<br><br>
						<div class="card-action">
							@if ($opinion->status == 1)
								<form action="{{ route('opinion.disagree', $opinion->id) }}" method="POST" style="display: inline;">
									@csrf
									@method('POST')
									<button type="submit" class="btn-floating waves-effect waves-light brown right tooltipped" data-tooltip="反對">
										<i class="material-icons">thumb_down</i>
									</button>
								</form>
								<form action="{{ route('opinion.agree', $opinion->id) }}" method="POST" style="display: inline;">
									@csrf
									@method('POST')
									<button type="submit" class="btn-floating waves-effect waves-light brown right tooltipped" data-tooltip="贊成">
										<i class="material-icons">thumb_up</i>
									</button>
								</form>
							@endif
						</div>
						<br><br>
						<form action="{{ route('opinion.destroy', $opinion->id) }}" method="POST">
							@csrf
							@method('DELETE')
							<button type="submit" class="waves-effect waves-light btn brown right">
								刪除
							</button>
						</form>
						<br><br>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<h3 id="count">總票數: {{ $opinion->count }}</h3>
		</div>
		<div class="row">
			<h3 id="agree">贊成票數: {{ $opinion->agree }}</h3>
			<br>
			<div class="progress">
				<div id="agreeProgressBar" class="determinate brown" style="width: {{ $agreeRatio }}%"></div>
			</div>
			<h3 id="agreeRatio" class="right">贊成比率: {{ $agreeRatio }}%</h3>
		</div>
		<div class="row">
			<h3 id="disagree">反對票數: {{ $opinion->disagree }}</h3>
			<br>
			<div class="progress">
				<div id="disagreeProgressBar" class="determinate brown" style="width: {{ $disagreeRatio }}%"></div>
			</div>
			<h3 id="disagreeRatio" class="right">反對比率: {{ $disagreeRatio }}%</h3>
		</div>
	</div>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')

@endsection

@section('scripts')

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$('form[action*="agree"]').on('submit', function(event) {
		event.preventDefault();
		const url = $(this).attr('action');
		
		$.ajax({
			type: 'POST',
			url: url,
			success: function(response) {
				updateOpinionData(response);
			},
			error: function (xhr) {
				if (xhr.status === 400) {
					var response = JSON.parse(xhr.responseText);
					alert(response.error);
				} else {
					alert('發生錯誤，請稍後再試。');
				}
			}
		});
	});

	$('form[action*="disagree"]').on('submit', function(event) {
		event.preventDefault();
		const url = $(this).attr('action');
		
		$.ajax({
			type: 'POST',
			url: url,
			success: function(response) {
				updateOpinionData(response);
			},
			error: function (xhr) {
				if (xhr.status === 400) {
					var response = JSON.parse(xhr.responseText);
					alert(response.error);
				} else {
					alert('發生錯誤，請稍後再試。');
				}
			}
		});
	});

    function updateOpinionData(data) {
        $('#count').text('總票數: ' + data.totalVotes);
        $('#agree').text('贊成票數: ' + data.agreeVotes);
        $('#disagree').text('反對票數: ' + data.disagreeVotes); 

        $('#agreeProgressBar').css('width', data.agreeRatio + '%');
        $('#agreeRatio').text('贊成比率: ' + data.agreeRatio + '%');

        $('#disagreeProgressBar').css('width', data.disagreeRatio + '%');
        $('#disagreeRatio').text('反對比率: ' + data.disagreeRatio + '%');
    }

</script>

@endsection