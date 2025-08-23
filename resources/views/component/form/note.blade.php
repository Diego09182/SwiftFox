<div id="modal1" class="modal">
	<div class="modal-content">
		<div class="col s12 m12">
			<div class="card white">
                <form name="NoteForm" method="post" action="{{ route('note.store') }}">
                    <div class="card-content black-text">
                        @csrf
                        <span class="card-title">發布日記</span>
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">mode_edit</i>
                                <input name="title" id="title" type="text" class="validate">
                                <label for="title">日記主題</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">mode_edit</i>
                                <input name="tag" id="tag" type="text" class="validate">
                                <label for="tag">日記標籤</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">mode_edit</i>
                                <textarea name="content" id="content" class="materialize-textarea"></textarea>
                                <label for="content">日記內容</label>
                            </div>
                        </div>
                        <br>
                        <div class="card-action">
                            <button class="waves-effect waves-light btn brown right" type="submit">發布日記</button>
                        </div>
                        <br>
                    </div>
                </form>
            </div>
		</div>
	</div>
</div>
