<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0"/>
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Swift Fox:開源的學生社群軟體" />
    <meta name="keywords" content="學生社群軟體" />
    <meta name="author" content="ssss.glad" />
    <title>Swift Fox</title>
	@vite(['resources/css/style.css','resources/css/materialize.css','resources/js/app.js','resources/js/materialize.js','resources/js/init.js'])
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
	<link rel="shortcut icon" href="{{ asset('images/SWIFT FOX ICON.ico') }}" type="image/x-icon" />
</head>
<body>

<div id="app">

	@include('component.navigation')

	@include('component.serve.message')

	@include('component.toolbar')

	<div class="container animate__animated animate__fadeInUp animate__delay-1s">
		<div class="row">
			<div class="col m12 s12">
				<div>
					<h3 class="animate__animated animate__fadeInDown"><b>{{ $article->title }}</b></h3>

					<div class="chip brown white-text animate__animated animate__fadeInUp animate__delay-1s">
						{{ $article->tag }}
					</div>

					<br><br>

					<div class="row animate__animated animate__fadeInRight animate__delay-1s">
						<a @click="decreaseFontSize" class="waves-light btn brown right"><b>A-</b></a>
						<a @click="increaseFontSize" class="waves-light btn brown right"><b>A+</b></a>

						@if(Auth::user()->administration == 5 || $article->user->id == Auth::user()->id)
							<form action="{{ route('article.destroy', ['article' => $article->id ]) }}" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" class="waves-effect waves-light btn brown left">
									<i class="material-icons">delete</i>
								</button>
							</form>
						@endif
					</div>

					<h5 class="left animate__animated animate__fadeInLeft animate__delay-1s"><b>作者: {{ $article->user->account }}</b></h5>
					<h5 class="right animate__animated animate__fadeInRight animate__delay-1s"><b>發文時間: {{ $article->created_at }}</b></h5>
				</div>

				<br><br><br>
				<hr id="divider">

				<article class="animate__animated animate__fadeIn animate__delay-2s">
					<h5 :style="{ fontSize: fontSize + 'px', 'word-wrap': 'break-word' }">
						{!! \Illuminate\Support\Str::markdown($article->content) !!}
					</h5>
				</article>
			</div>
		</div>
	</div>

	<br><br>

    @include('component.footer')

</div>

</body>
</html>

<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('.fixed-action-btn').floatingActionButton({
			direction: 'left',
			hoverEnabled: false
		});
		$('.tabs').tabs();
		$('.parallax').parallax();
		$('.button-collapse').sidenav();
		$('.carousel.carousel-slider').carousel({ fullWidth: true });
		$('.modal').modal();
		$('.materialboxed').materialbox();
		$('.tooltipped').tooltip();
		$('.chips').chips();
		$('.collapsible').collapsible();
		$('.carousel').carousel();
		$('.slider').slider({
			height: 300,
			duration: 500,
		});
		$('select').formSelect();
		$('.sidenav').sidenav();
	});

    const app = Vue.createApp({
      data() {
        return {
          fontSize: 30,
          minFontSize: 20,
          maxFontSize: 70,
        };
      },
      methods: {
        increaseFontSize() {
          if (this.fontSize < this.maxFontSize) {
            this.fontSize += 5;
          }
        },
        decreaseFontSize() {
          if (this.fontSize > this.minFontSize) {
            this.fontSize -= 5;
          }
        },
      },
    });

    app.mount('#app');

</script>
</body>
</html>
