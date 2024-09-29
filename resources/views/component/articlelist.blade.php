<h4 class="center">文章列表</h4>
@if ($posts->isEmpty())
	<h3 class="center-align">目前沒有文章</h3>
@else
	<ul class="pagination center">
		@if ($articles->currentPage() > 1)
			<li class="waves-effect"><a href="{{ $articles->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
		@endif
		@for ($i = 1; $i <= $articles->lastPage(); $i++)
			@if ($i == 1 || $i == $articles->lastPage() || abs($articles->currentPage() - $i) < 3 || $i == $articles->currentPage())
				<li class="waves-effect {{ $i == $articles->currentPage() ? 'active brown' : '' }}"><a href="{{ $articles->url($i) }}">{{ $i }}</a></li>
			@elseif (abs($articles->currentPage() - $i) === 3)
				<li class="disabled">
					<span>...</span>
				</li>
			@endif
		@endfor
		@if ($articles->hasMorePages())
			<li class="waves-effect"><a href="{{ $articles->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
		@endif
	</ul>
	<table class="striped">
		<thead>
			<tr>
				<th>文章主題</th>
				<th>文章標籤</th>
				<th>發表時間</th>
				<th>操作</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($articles as $article)
				<tr>
					<td>{{ $article->title }}</td>
					<td>{{ $article->tag }}</td>
					<td>{{ $article->created_at }}</td>
					<td>
						<form action="{{ route('article.destroy', ['article' => $article->id ]) }}" method="POST">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn-floating waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="刪除">
								<i class="material-icons">delete</i>
							</button>
						</form>
					</td>
					<td>
						<a href="{{ route('article.show', ['article' => $article->id ]) }}" class="btn waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="查看貼文">
							查看
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endif