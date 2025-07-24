<div class="container">
    <div class="card" style="background-color: white; color: black;">
        <form id="activityForm" name="ActivityForm" method="post" action="{{ route('activity.store') }}">
            @csrf
            <div class="card-content">
                <span class="card-title" style="color: black;">創建活動</span>
                <div class="row">
                    <div class="input-field col m12">
                        <i class="material-icons prefix" style="color: black;">mode_edit</i>
                        <input class="validate" value="{{ old('title') }}" name="title" type="text" id="activity-title" style="color: black;">
                        <label for="activity-title" style="color: black;">活動名稱</label>
                    </div>
                    <div class="input-field col m12">
                        <i class="material-icons prefix" style="color: black;">mode_edit</i>
                        <input class="validate" value="{{ old('content') }}" name="content" type="text" id="activity-content" style="color: black;">
                        <label for="activity-content" style="color: black;">活動內容</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m6">
                        <i class="material-icons prefix" style="color: black;">mode_edit</i>
                        <input class="validate" value="{{ old('location') }}" name="location" type="text" id="activity-location" style="color: black;">
                        <label for="activity-location" style="color: black;">活動地點</label>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix" style="color: black;">date_range</i>
                        <input name="date" value="{{ old('date') }}" type="text" id="activity-date" class="datepicker" style="color: black;">
                        <label for="activity-date" style="color: black;">活動時間</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m12">
                        <i class="material-icons prefix" style="color: black;">mode_edit</i>
                        <input class="validate" value="{{ old('url') }}" name="url" type="text" id="activity-url" style="color: black;">
                        <label for="activity-url" style="color: black;">相關連結</label>
                    </div>
                </div>
                <button class="waves-effect waves-light btn brown right" type="submit">創建活動</button>
                <br>
            </div>
        </form>
    </div>
</div>
