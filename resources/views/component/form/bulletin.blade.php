<div class="container">
	<div class="card blue-grey darken-1">
		<form id="bulletinForm" method="post" action="{{ route('bulletin.store') }}">
			@csrf
			<div class="card-content white-text">
				<span class="card-title">公告主題</span>
				<div class="row">
					<div class="input-field col m12">
						<i class="material-icons prefix">mode_edit</i>
						<input class="validate" name="title" type="text" id="bulletin-title">
						<label for="icon_prefix2">公告主題</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col m12">
						<i class="material-icons prefix">mode_edit</i>
						<textarea class="materialize-textarea" name="content" id="bulletin-content"></textarea>
						<label for="icon_prefix2">公告內容</label>
					</div>
				</div>
				<button class="waves-effect waves-light btn brown right" type="submit">發布公告</button>
				<br>
			</div>
		</form>
	</div>
</div>