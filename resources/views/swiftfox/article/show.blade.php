@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	<br>

	@include('component.toolbar')

    <div class="container animate__animated animate__fadeInUp animate__delay-1s">
        <div class="row">
            <div class="col s12">

                <h3 class="animate__animated animate__fadeInDown">
                    <b>{{ $article->title }}</b>
                </h3>

                <div class="chip brown white-text">
                    {{ $article->tag }}
                </div>

                <br><br>

                <div class="row">
                    <a id="font-minus" class="waves-light btn brown right" style="margin:0 8px;">
                        <b>A-</b>
                    </a>
                    <a id="font-plus" class="waves-light btn brown right" style="margin:0 8px;">
                        <b>A+</b>
                    </a>

                    @if(Auth::user()->administration == 5 || $article->user->id == Auth::user()->id)
                        <form action="{{ route('article.destroy', $article->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="waves-effect waves-light btn brown left">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>
                    @endif
                </div>

                <h5 class="left"><b>作者：{{ $article->user->account }}</b></h5>
                <h5 class="right"><b>發文時間：{{ $article->created_at }}</b></h5>

                <div class="clearfix"></div>

                <hr>

                <article id="article-content" class="animate__animated animate__fadeIn animate__delay-2s">
                    {!! \Illuminate\Support\Str::markdown($article->content) !!}
                </article>

            </div>
        </div>
    </div>

	<br>

	@include('component.contact')

	<br>

    @include('component.footer')

</div>

@endsection

<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
<script>
$(document).ready(function () {

    $('.datepicker').datepicker({ format: 'yyyy-mm-dd' })
    $('.fixed-action-btn').floatingActionButton({ direction: 'left', hoverEnabled: false })
    $('.tabs').tabs()
    $('.parallax').parallax()
    $('.sidenav').sidenav()
    $('.carousel').carousel()
    $('.modal').modal()
    $('.materialboxed').materialbox()
    $('.tooltipped').tooltip()
    $('.chips').chips()
    $('.collapsible').collapsible()
    $('select').formSelect()
    $('.slider').slider({ height: 300, duration: 500 })

    let fontSize = 30
    const minFontSize = 20
    const maxFontSize = 40

    $('#article-content').css('font-size', fontSize + 'px')

    $('#font-plus').on('click', function () {
        if (fontSize < maxFontSize) {
            fontSize += 5
            $('#article-content').css('font-size', fontSize + 'px')
        }
    })

    $('#font-minus').on('click', function () {
        if (fontSize > minFontSize) {
            fontSize -= 5
            $('#article-content').css('font-size', fontSize + 'px')
        }
    })
})
</script>
</body>
</html>
