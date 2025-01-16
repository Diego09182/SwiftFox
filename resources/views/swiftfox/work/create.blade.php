@extends('layouts.app')

@section('content')

<div id="app">
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<div class="container">
		<div class="card blue-grey darken-1">
			<form name="WorkForm" method="post" action="{{ route('work.store') }}">
                @csrf
				<div class="card-content white-text">
					<span class="card-title">創建作品集</span>
					<div class="row">
						<div class="input-field col m12">
							<i class="material-icons prefix">mode_edit</i>
							<input class="validate" name="name" type="text">
							<label for="icon_prefix2">作品集名稱</label>
						</div>
					</div>
			        <button class="waves-effect waves-light btn brown right" type="submit">發布作品</button>
                    <br>
				</div>
			</form>
		</div>
	</div>

	<br>
	
	@include('component.contact')
	
	<br>
	
    @include('component.footer')
	
</div>

@endsection