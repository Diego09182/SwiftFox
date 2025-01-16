<div class="container">
    <div class="card blue-grey darken-1">
        <form id="activityForm" name="ActivityForm" method="post" action="{{ route('activity.store') }}">
            @csrf
            <div class="card-content white-text">
                <span class="card-title">創建活動</span>
                <div class="row">
                    <div class="input-field col m12">
                        <i class="material-icons prefix">mode_edit</i>
                        <input class="validate" value="{{ old('title') }}" name="title" type="text" id="activity-title">
                        <label for="icon_prefix2">活動名稱</label>
                    </div>
                    <div class="input-field col m12">
                        <i class="material-icons prefix">mode_edit</i>
                        <input class="validate" value="{{ old('content') }}" name="content" type="text" id="activity-content">
                        <label for="icon_prefix2">活動內容</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m6">
                        <i class="material-icons prefix">mode_edit</i>
                        <input class="validate" value="{{ old('location') }}" name="location" type="text" id="activity-location">
                        <label for="icon_prefix2">活動地點</label>
                    </div>
                    <div class="input-field col m6 black-text">
                        <i class="material-icons prefix">date_range</i>
                        <input name="date" value="{{ old('date') }}" type="text" id="activity-date" class="datepicker">
                        <label for="icon_prefix">活動時間</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m12">
                        <i class="material-icons prefix">mode_edit</i>
                        <input class="validate" value="{{ old('url') }}" name="url" type="text" id="activity-url">
                        <label for="icon_prefix2">相關連結</label>
                    </div>
                </div>
                <button class="waves-effect waves-light btn brown right" type="submit">創建活動</button>
                <br>
            </div>
        </form>
    </div>
</div>