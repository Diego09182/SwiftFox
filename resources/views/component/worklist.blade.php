<h4 class="center">作品列表</h4>
@if ($works->isEmpty())
	<h3 class="center-align">目前沒有作品</h3>
@else
	<ul class="pagination center">
		@if ($works->currentPage() > 1)
			<li class="waves-effect"><a href="{{ $works->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
		@endif
		@for ($i = 1; $i <= $works->lastPage(); $i++)
			@if ($i == 1 || $i == $works->lastPage() || abs($works->currentPage() - $i) < 3 || $i == $works->currentPage())
				<li class="waves-effect {{ $i == $works->currentPage() ? 'active brown' : '' }}"><a href="{{ $works->url($i) }}">{{ $i }}</a></li>
			@elseif (abs($works->currentPage() - $i) === 3)
				<li class="disabled">
					<span>...</span>
				</li>
			@endif
		@endfor
		@if ($works->hasMorePages())
			<li class="waves-effect"><a href="{{ $works->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
		@endif
	</ul>
	<table class="striped">
		<thead>
			<tr>
				<th>作品名稱</th>
				<th>創建時間</th>
				<th>操作</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($works as $work)
				<tr>
					<td>{{ $work->name }}</td>
					<td>{{ $work->created_at }}</td>
					<td>
						<form action="{{ route('work.destroy', ['work' => $work->id ]) }}" method="POST">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn-floating waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="刪除">
								<i class="material-icons">delete</i>
							</button>
						</form>
					</td>
					<td>
						<a href="{{ route('work.show', ['work' => $work->id ]) }}" class="btn waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="查看貼文">
							查看
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endif