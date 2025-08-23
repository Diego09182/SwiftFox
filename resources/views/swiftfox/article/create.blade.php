@extends('layouts.app')

@section('content')

<div id="app">

	@include('component.navigation')

    @include('component.serve.message')

    @include('component.logoutbanner')

    @include('component.toolbar')

	<div class="container">
        <div class="card">
            <form name="ArticleForm" method="post" action="{{ route('article.store') }}">
                @csrf
                <div class="card-content black-text">
                    <span class="card-title">發表文章</span>
                    <div class="row">
                        <div class="input-field col m8">
                            <i class="material-icons prefix">mode_edit</i>
                            <input class="validate" name="title" type="text" value="{{ old('title') }}" size="10" maxlength="10">
                            <label for="icon_prefix2">主題</label>
                            @error('title')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-field col m4">
                            <select name="tag">
                                <option value="" disabled {{ old('tag') ? '' : 'selected' }}>選擇文章標籤</option>
                                <option value="大學面試" {{ old('tag') == '大學面試' ? 'selected' : '' }}>大學面試</option>
                                <option value="競賽經驗" {{ old('tag') == '競賽經驗' ? 'selected' : '' }}>競賽經驗</option>
                                <option value="學習歷程" {{ old('tag') == '學習歷程' ? 'selected' : '' }}>學習歷程</option>
                                <option value="活動分享" {{ old('tag') == '活動分享' ? 'selected' : '' }}>活動分享</option>
                            </select>
                            @error('tag')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <div class="input-field">
                                <textarea id="markdown-editor" name="content">{{ old('content') }}</textarea>
                                @error('content')
                                    <span class="red-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button class="waves-effect waves-light btn brown right" type="submit">發布文章</button>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    new EasyMDE({
        element: document.getElementById("markdown-editor"),
        spellChecker: false,
        autosave: {
            enabled: true,
            uniqueId: "article_content",
            delay: 1000,
        },
        placeholder: "在此輸入內容，支援 Markdown 語法",
        toolbar: [
            "bold", "italic", "heading", "|",
            "quote", "unordered-list", "ordered-list", "|",
            "link", "image", "table", "|",
            "preview", "side-by-side", "fullscreen", "|",
            "guide"
        ],
    });
});
</script>
