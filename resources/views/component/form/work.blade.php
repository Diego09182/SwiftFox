<div id="modal1" class="modal">
	<div class="modal-content">
		<div class="card blue-grey darken-1 card">
			<form name="WorkForm" method="post" action="{{ route('work.store') }}">
                @csrf
				<div class="card-content white-text">
					<span class="card-title">創建作品集</span>
                    <div class="row">
						<div class="input-field col m5 right">
                            <h5>帳號:{{ Auth::user()->account }}</h5>
						</div>
					</div>
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
</div>