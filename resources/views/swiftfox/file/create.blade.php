@extends('layouts.app')

@section('content')

<div id="app">
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<div class="container">
		<div class="card blue-grey darken-1">
			<form name="FileForm" method="post" action="{{ route('file.store') }}" enctype="multipart/form-data">
				@csrf
				<div class="card-content white-text">
					<span class="card-title">新增檔案</span>
					
					<div class="row">
						<div class="input-field col m12">
							<i class="material-icons prefix">title</i>
							<input class="validate" name="title" type="text">
							<label for="title">標題</label>
						</div>
					</div>
					
					<div class="row">
						<div class="input-field col m12">
							<i class="material-icons prefix">description</i>
							<textarea class="materialize-textarea" name="content"></textarea>
							<label for="content">內容</label>
						</div>
					</div>
					
					<div class="row">
						<div class="file-field input-field col m12">
							<div class="btn brown">
								<span>選擇檔案</span>
								<input type="file" name="file">
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text">
							</div>
						</div>
					</div>

					<button class="waves-effect waves-light btn brown right" type="submit">上傳檔案</button>
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
