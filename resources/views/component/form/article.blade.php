<div id="modal1" class="modal">
	<div class="modal-content">
		<div class="card blue-grey darken-1">
			<form name="ArticleForm" method="post" action="{{ route('article.store') }}">
                @csrf
				<div class="card-content white-text">
					<span class="card-title">發表文章</span>
					<div class="row">
						<div class="input-field col m8">
							<i class="material-icons prefix">mode_edit</i>
							<input class="validate" value="{{ old('title') }}" name="title" type="text">
							<label for="icon_prefix2">主題</label>
						</div>
						<div class="input-field col m4">
							<select name="tag">
								<option value="" disabled selected>選擇文章標籤</option>
								<option value="大學面試">大學面試</option>
								<option value="競賽經驗">競賽經驗</option>
								<option value="學習歷程">學習歷程</option>
								<option value="活動分享">活動分享</option>
							</select>
							<label>文章標籤</label>
						</div>
					</div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea class="materialize-textarea" value="{{ old('content') }}" name="content"></textarea>
                            <label for="icon_prefix2">內容</label>
                        </div>
                    </div>
					<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right">關閉</a>
			        <button class="waves-effect waves-light btn brown right" type="submit">發布文章</button>
                    <br>
				</div>
			</form>
		</div>
	</div>
</div>