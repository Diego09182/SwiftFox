<div id="modal1" class="modal">
	<div class="modal-content">
		<div class="card blue-grey darken-1 card">
			<form name="PostForm" method="post" action="{{ route('comment.store', ['post' => $post->id]) }}">
                @csrf
				<div class="card-content white-text">
					<span class="card-title">發布評論</span>
                    <div class="row">
						<div class="input-field col m5 right">
                            <h5>帳號:{{ Auth::user()->account }}</h5>
						</div>
					</div>
					<div class="row">
						<div class="input-field col m12">
							<i class="material-icons prefix">mode_edit</i>
							<input class="validate" name="title" type="text">
							<label for="icon_prefix2">主題</label>
						</div>
					</div>
                    <div class="row">
                        <div class="input-field col m12">
                            <div class="input-field">
                                <i class="material-icons prefix">mode_edit</i>
                                <textarea class="materialize-textarea" name="content"></textarea>
                                <label for="icon_prefix2">內容</label>
                            </div>
                        </div>
                    </div>
					<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right">關閉</a>
			        <button class="waves-effect waves-light btn brown right" type="submit">發布評論</button>
                    <br>
				</div>
			</form>
		</div>
	</div>
</div>