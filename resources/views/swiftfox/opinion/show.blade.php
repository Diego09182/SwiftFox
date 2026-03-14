@extends('layouts.app')

@section('content')

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	<br>

	@include('component.toolbar')

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
                            <h5 class="center">{{ $opinion->user->account }}</h5>
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
                            <h5 class="left">等級標章:
                                @php
                                    $times = $opinion->user->times;
                                @endphp
                                @if ($times >= 100)
                                    <span class="badge gold" title="鑽石會員">💎 鑽石會員</span>
                                @elseif ($times >= 50)
                                    <span class="badge silver" title="白金會員">🥈 白金會員</span>
                                @elseif ($times >= 20)
                                    <span class="badge bronze" title="金牌會員">🥉 金牌會員</span>
                                @elseif ($times >= 10)
                                    <span class="badge blue" title="青銅會員">🔵 青銅會員</span>
                                @else
                                    <span class="badge gray" title="新手會員">⚪ 新手會員</span>
                                @endif
                            </h5>
                            <br><br><br>
                            <h5 class="left">個人網站:</h5>
                                @if ($opinion->user->url)
                                    <h5>{{ $opinion->user->url }}</h5>
                                    <a href="{{ $opinion->user->url }}" class="modal-action modal-close waves-effect waves-green brown btn right">前往</a>
                                @endif
                            <br><br><br>
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
                    <ul class="collapsible animate__animated animate__fadeInLeft animate__delay-1s" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header"><i class="material-icons">info</i>等級徽章</div>
                            <div class="collapsible-body center">
                                <div style="text-align: center; font-size: 1.8rem; display: inline-flex; align-items: center; gap: 0.6rem; justify-content: center; flex-wrap: wrap;">
                                    @php
                                        $times = $opinion->user->times;
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
			<div class="col s12 m9 right">
				<div class="card">
					<br><br>
                        <div class="card-content center">
                            <div class="row">
                            <h3 class="center animate__animated animate__fadeInDown animate__delay-1s"><b>{{ $opinion->title }}</b></h3>
                        </div>
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
                        <hr>
                        <h4
                            class="post-content animate__animated animate__fadeIn animate__delay-2s"
                            style="line-height: 1.8; word-break: break-word; overflow-wrap: break-word;">
                            {!! $opinion->content !!}
                        </h4>
						<p class="right">創建時間: {{ $opinion->created_at }}</p>
						<br>
						<p class="right">結束時間: {{ $opinion->finished_time }}</p>
						<br><br>
						<div class="card-action">
							@if ($opinion->status == 1)
								<form action="{{ route('opinion.disagree', $opinion->id) }}" method="POST" style="display: inline;">
									@csrf
									@method('POST')
									<button type="submit" onclick="launchConfetti()" class="btn-floating waves-effect waves-light brown right tooltipped" style="margin-left:8px; margin-right:8px;" data-tooltip="反對">
										<i class="material-icons">thumb_down</i>
									</button>
								</form>
								<form action="{{ route('opinion.agree', $opinion->id) }}" method="POST" style="display: inline;">
									@csrf
									@method('POST')
									<button type="submit" onclick="launchConfetti()" class="btn-floating waves-effect waves-light brown right tooltipped" style="margin-left:8px; margin-right:8px;" data-tooltip="贊成">
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
            <div class="card-panel z-depth-2">
                <h4><b id="count">總票數: {{ $opinion->count }}</b></h4>
                <div class="section">
                    <h4><b id="agree">贊成票數: {{ $opinion->agree }}</b></h4>
                    <div class="progress">
                        <div
                            id="agreeProgressBar"
                            class="determinate green"
                            style="width: {{ $agreeRatio }}%">
                        </div>
                    </div>
                    <h4 id="agreeRatio" class="right green-text">
                        <b>贊成比率: {{ $agreeRatio }}%</b>
                    </h4>
                </div>
                <div class="section">
                    <h4><b id="disagree">反對票數: {{ $opinion->disagree }}</b></h4>
                    <div class="progress">
                        <div
                            id="disagreeProgressBar"
                            class="determinate red"
                            style="width: {{ $disagreeRatio }}%">
                        </div>
                    </div>
                    <h4 id="disagreeRatio" class="right red-text">
                        <b>反對比率: {{ $disagreeRatio }}%</b>
                    </h4>
                </div>
                <br><br>
            </div>
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
					M.toast({html: response.error});
				} else {
					M.toast({
                        html: '已經投過票了。',
                        displayLength: 3000,
                        classes: 'rounded red lighten-2'
                    });
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
					M.toast({html: response.error});
				} else {
					M.toast({
                        html: '已經投過票了。',
                        displayLength: 3000,
                        classes: 'rounded red lighten-2'
                    });
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

	function launchConfetti() {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 },
        });
    }

</script>

@endsection
