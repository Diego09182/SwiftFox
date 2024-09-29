<div id="modal1" class="modal">
	<div class="modal-content">
		<div class="card blue-grey darken-1">
			<form name="AvatarForm" method="post" action="{{ route('avatar.store') }}">
                @csrf
				<div class="card-content white-text">
					<span class="card-title">上傳頭像</span>
					<div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>圖片上傳</span>
                                <input type="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input name="file" class="file-path validate" type="text">
                            </div>
                        </div>
					</div>
					<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right">關閉</a>
			        <button class="waves-effect waves-light btn brown right" type="submit">上傳頭像</button>
                    <br>
				</div>
			</form>
		</div>
	</div>
</div>