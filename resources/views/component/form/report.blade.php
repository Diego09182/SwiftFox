<div id="modal3" class="modal">
    <div class="modal-content">
        <div class="card blue-grey darken-1">
            <form name="ReportForm" method="post" action="{{ route('report.store', ['post' => $post->id]) }}">
                @csrf
                <div class="card-content white-text">
                    <span class="card-title">檢舉貼文</span>
                    <div class="row">
                        <div class="input-field col m8">
                            <i class="material-icons prefix">mode_edit</i>
                            <input class="validate" value="{{ old('title') }}" name="title" type="text">
                            <label for="icon_prefix2">檢舉標題</label>
                        </div>
                        <div class="input-field col m4">
                            <select name="tag">
                                <option value="" disabled selected>違規事項</option>
                                <option value="違法行為">違法行為</option>
                                <option value="仇恨內容">仇恨內容</option>
                                <option value="垃圾內容">垃圾內容</option>
                                <option value="未授權的產品及服務">未授權的產品及服務</option>
                            </select>
                            <label>貼文標籤</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea class="materialize-textarea" name="content"></textarea>
                            <label for="icon_prefix2">附註內容</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-light btn brown right" type="submit">送出檢舉</button>
                    <br>
                </div>
            </form>
        </div>
    </div>
</div>
