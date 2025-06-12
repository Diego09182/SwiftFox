@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	<div class="container">
		<div class="card blue-grey darken-1">
			<form name="PostForm" method="post" action="{{ route('forum.store') }}">
                @csrf
				<div class="card-content white-text">
					<span class="card-title">發表貼文</span>
					<div class="row">
						<div class="input-field col m8">
							<i class="material-icons prefix">mode_edit</i>
							<input class="validate" name="title" type="text">
							<label for="icon_prefix2">主題</label>
						</div>
						<div class="input-field col m4">
							<select name="tag">
								<option value="" disabled selected>貼文標籤</option>
								<option value="學習問題">學習問題</option>
								<option value="學習資源">學習資源</option>
								<option value="活動宣傳">活動宣傳</option>
								<option value="其他內容">其他內容</option>
							</select>
							<label>貼文標籤</label>
						</div>
					</div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea class="materialize-textarea" name="content"></textarea>
                            <label for="icon_prefix2">內容</label>
                        </div>
                    </div>
			        <button class="waves-effect waves-light btn brown right" type="submit">發布貼文</button>
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
