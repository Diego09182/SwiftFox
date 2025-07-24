<div class="container">
    <div class="card" style="background-color: white; color: black;">
        <form id="clubForm" method="post">
            @csrf
            <div class="card-content">
                <span class="card-title" style="color: black;">創建社團</span>
                <div class="row">
                    <div class="input-field col m8">
                        <i class="material-icons prefix" style="color: black;">mode_edit</i>
                        <input class="validate" id="club-title" value="{{ old('title') }}" name="title" type="text" style="color: black;">
                        <label for="club-title" style="color: black;">社團名稱</label>
                    </div>
                    <div class="input-field col m4">
                        <select id="tag" name="tag" style="color: black;">
                            <option value="" disabled selected>社團分類</option>
                            <option value="學術性社團">學術性社團</option>
                            <option value="體能性社團">體能性社團</option>
                            <option value="藝術性社團">藝術性社團</option>
                            <option value="服務性社團">服務性社團</option>
                            <option value="聯誼性社團">聯誼性社團</option>
                            <option value="綜合性社團">綜合性社團</option>
                        </select>
                        <label style="color: black;">社團分類</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m4">
                        <i class="material-icons prefix" style="color: black;">mode_edit</i>
                        <input class="validate" id="teacher" value="{{ old('teacher') }}" name="teacher" type="text" style="color: black;">
                        <label for="teacher" style="color: black;">指導教師</label>
                    </div>
                    <div class="input-field col m4">
                        <i class="material-icons prefix" style="color: black;">mode_edit</i>
                        <input class="validate" id="director" value="{{ old('director') }}" name="director" type="text" style="color: black;">
                        <label for="director" style="color: black;">社長名稱</label>
                    </div>
                    <div class="input-field col m4">
                        <i class="material-icons prefix" style="color: black;">mode_edit</i>
                        <input class="validate" id="vice_director" value="{{ old('vice_director') }}" name="vice_director" type="text" style="color: black;">
                        <label for="vice_director" style="color: black;">副社長名稱</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m12">
                        <i class="material-icons prefix" style="color: black;">mode_edit</i>
                        <textarea class="materialize-textarea" id="club-content" name="content" style="color: black;">{{ old('content') }}</textarea>
                        <label for="club-content" style="color: black;">社團介紹</label>
                    </div>
                </div>
                <button class="waves-effect waves-light btn brown right" type="submit">創建社團</button>
                <br>
            </div>
        </form>
    </div>
</div>

