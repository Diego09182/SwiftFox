<div class="container">
	<div class="card" style="background-color: white; color: black;">
		<form id="bulletinForm" method="post" action="{{ route('bulletin.store') }}">
			@csrf
			<div class="card-content">
				<span class="card-title" style="color: black;">公告主題</span>
				<div class="row">
					<div class="input-field col m12">
						<i class="material-icons prefix" style="color: black;">mode_edit</i>
						<input class="validate" name="title" type="text" id="bulletin-title" style="color: black;">
						<label for="bulletin-title" style="color: black;">公告主題</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col m12">
						<i class="material-icons prefix" style="color: black;">mode_edit</i>
						<textarea class="materialize-textarea" name="content" id="bulletin-content" style="color: black;"></textarea>
						<label for="bulletin-content" style="color: black;">公告內容</label>
					</div>
				</div>
				<button class="waves-effect waves-light btn brown right" type="submit">發布公告</button>
				<br>
			</div>
		</form>
	</div>
</div>
