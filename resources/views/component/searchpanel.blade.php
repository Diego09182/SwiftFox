<div class="container">
    <div class="card-panel z-depth-2">
        <div class="row">
            <form action="{{ route('forum.search') }}" method="GET" class="col s12 m8">
                <div class="input-field">
                    <i class="material-icons prefix">search</i>
                    <input name="search" id="icon_prefix" type="text" class="validate">
                    <label for="icon_prefix">搜尋貼文</label>
                </div>
            </form>
            <form action="{{ route('forum.filter') }}" method="GET" class="col s12 m4">
                <div class="input-field">
                    <select name="filter">
                        <option value="" disabled selected>熱度篩選</option>
                        <option value="觀看次數">觀看次數</option>
                        <option value="喜歡次數">喜歡次數</option>
                    </select>
                    <label>篩選條件</label>
                </div>
                <div class="right-align">
                    <button type="submit" class="btn brown waves-effect waves-light">
                        <i class="material-icons left">filter_list</i>篩選
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
