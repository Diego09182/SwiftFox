<div class="container">
    <div class="card blue-grey darken-1">
        <form id="clubForm" method="post">
            @csrf
            <div class="card-content white-text">
                <span class="card-title">創建社團</span>
                <div class="row">
                    <div class="input-field col m8">
                        <i class="material-icons prefix">mode_edit</i>
                        <input class="validate" id="club-title" value="{{ old('title') }}" name="title" type="text">
                        <label for="title">社團名稱</label>
                    </div>
                    <div class="input-field col m4">
                        <select id="tag" name="tag">
                            <option value="" disabled selected>社團分類</option>
                            <option value="學術性社團">學術性社團</option>
                            <option value="體能性社團">體能性社團</option>
                            <option value="藝術性社團">藝術性社團</option>
                            <option value="服務性社團">服務性社團</option>
                            <option value="聯誼性社團">聯誼性社團</option>
                            <option value="綜合性社團">綜合性社團</option>
                        </select>
                        <label>社團分類</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m4">
                        <i class="material-icons prefix">mode_edit</i>
                        <input class="validate" id="teacher" value="{{ old('teacher') }}" name="teacher" type="text">
                        <label for="teacher">指導教師</label>
                    </div>
                    <div class="input-field col m4">
                        <i class="material-icons prefix">mode_edit</i>
                        <input class="validate" id="director" value="{{ old('director') }}" name="director" type="text">
                        <label for="director">社長名稱</label>
                    </div>
                    <div class="input-field col m4">
                        <i class="material-icons prefix">mode_edit</i>
                        <input class="validate" id="vice_director" value="{{ old('vice_director') }}" name="vice_director" type="text">
                        <label for="vice_director">副社長名稱</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m12">
                        <i class="material-icons prefix">mode_edit</i>
                        <textarea class="materialize-textarea" id="club-content" name="content">{{ old('content') }}</textarea>
                        <label for="content">社團介紹</label>
                    </div>
                </div>
                <button class="waves-effect waves-light btn brown right" type="submit">創建社團</button>
                <br>
            </div>
        </form>
    </div>
</div>