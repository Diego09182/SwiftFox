@extends('layouts.app')

@section('content')
	
	@include('component.navigation')
	
    @include('component.serve.message')

    @include('component.logoutbanner')
	
	<div class="fixed-action-btn click-to-toggle">
		<a class="btn-floating btn-large red">
			<i class="large material-icons brown">menu</i>
		</a>
		<ul>
			<li>
				<a href="{{route('home.index')}}"class="btn-floating yellow tooltipped modal-trigger" data-position="top" data-tooltip="我的小屋">
					<i class="material-icons">view_quilt</i>
				</a>
			</li>
			<li>
				<a href="{{route('profile.index')}}" class="btn-floating green tooltipped modal-trigger" data-position="top" data-tooltip="個人資料">
					<i class="material-icons">perm_identity</i>
				</a>
			</li>
		</ul>
	</div>

	<div class="container">
		<div class="row">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab col s3"><a href="#clubForm">創建社團</a></li>
					<li class="tab col s3"><a href="#activityForm">創建活動</a></li>
					<li class="tab col s3"><a href="#bulletinForm">發布公告</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div id="clubForm" class="col s12">
		@include('component.form.club')
	</div>
	<div id="activityForm" class="col s12">
		@include('component.form.activity')
	</div>
	<div id="bulletinForm" class="col s12">
		@include('component.form.bulletin')
	</div>

	@include('component.managementlist')

    <div class="container">
        <h4 class="center">貼文列表</h4>
        @if ($posts->isEmpty())
            <h3 class="center-align">目前沒有貼文</h3>
        @else
            <ul class="pagination center">
                @if ($posts->currentPage() > 1)
                    <li class="waves-effect"><a href="{{ $posts->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
                @endif
                @for ($i = 1; $i <= $posts->lastPage(); $i++)
                    @if ($i == 1 || $i == $posts->lastPage() || abs($posts->currentPage() - $i) < 3 || $i == $posts->currentPage())
                        <li class="waves-effect {{ $i == $posts->currentPage() ? 'active brown' : '' }}"><a href="{{ $posts->url($i) }}">{{ $i }}</a></li>
                    @elseif (abs($posts->currentPage() - $i) === 3)
                        <li class="disabled">
                            <span>...</span>
                        </li>
                    @endif
                @endfor
                @if ($posts->hasMorePages())
                    <li class="waves-effect"><a href="{{ $posts->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
                @endif
            </ul>
            <table class="striped">
                <thead>
                    <tr>
                        <th>貼文主題</th>
                        <th>貼文標籤</th>
                        <th>發表時間</th>
                        <th>操作</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->tag }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td>
                                <form action="{{ route('forum.destroy', ['post' => $post->id ]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-floating waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="刪除">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('forum.show', ['post' => $post->id ]) }}" class="btn waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="查看資源">
                                    查看
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
	<br>
	
    @include('component.footer')
	
@endsection