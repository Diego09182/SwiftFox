@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

	<div class="container">
        <div class="card blue-grey darken-1">
            <form name="PostForm" method="post" action="{{ route('forum.store') }}">
                @csrf
                <div class="card-content white-text">
                    <span class="card-title">發表貼文</span>

                    <div class="row">
                        <div class="input-field col m8">
                            <i class="material-icons prefix">mode_edit</i>
                            <input class="validate white-text" name="title" type="text" value="{{ old('title') }}">
                            <label for="icon_prefix2">主題</label>
                            @error('title')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col m4">
                            <select name="tag">
                                <option value="" disabled {{ old('tag') ? '' : 'selected' }}>貼文標籤</option>
                                <option value="學習問題" {{ old('tag') == '學習問題' ? 'selected' : '' }}>學習問題</option>
                                <option value="學習資源" {{ old('tag') == '學習資源' ? 'selected' : '' }}>學習資源</option>
                                <option value="活動宣傳" {{ old('tag') == '活動宣傳' ? 'selected' : '' }}>活動宣傳</option>
                                <option value="其他內容" {{ old('tag') == '其他內容' ? 'selected' : '' }}>其他內容</option>
                            </select>
                            @error('tag')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea class="materialize-textarea white-text" name="content">{{ old('content') }}</textarea>
                            <label for="icon_prefix2">內容</label>
                            @error('content')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button class="waves-effect waves-light btn brown right" type="submit">發布貼文</button>
                    <br>
                </div>
            </form>
        </div>
    </div>

	<br>

	@include('component.contact')

	<br>

    @include('component.footer')

</div>

@endsection
