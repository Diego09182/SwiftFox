@extends('layouts.app')

@section('content')
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<div class="container">
		<div class="card blue-grey darken-1">
			<form name="OpinionForm" method="post" action="{{ route('opinion.store') }}">
                @csrf
				<div class="card-content white-text">
					<span class="card-title">發表投票</span>
					<div class="row">
						<div class="input-field col m8">
							<i class="material-icons prefix">mode_edit</i>
							<input class="validate" value="{{ old('title') }}" name="title" type="text">
							<label for="icon_prefix2">投票主題</label>
						</div>
						<div class="input-field col m4 black-text">
							<i class="material-icons prefix">date_range</i>
							<input name="finished_time" type="text" id="icon_prefix" class="datepicker">
							<label for="icon_prefix">投票結束時間</label>
						</div>
					</div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea class="materialize-textarea" value="{{ old('content') }}" name="content"></textarea>
                            <label for="icon_prefix2">內容</label>
                        </div>
                    </div>
			        <button class="waves-effect waves-light btn brown right" type="submit">發表投票</button>
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