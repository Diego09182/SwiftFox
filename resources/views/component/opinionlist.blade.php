<h4 class="center">投票列表</h4>
@if ($opinions->isEmpty())
	<h3 class="center-align">目前沒有投票</h3>
@else
	<ul class="pagination center">
		@if ($opinions->currentPage() > 1)
			<li class="waves-effect"><a href="{{ $opinions->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
		@endif
		@for ($i = 1; $i <= $opinions->lastPage(); $i++)
			@if ($i == 1 || $i == $opinions->lastPage() || abs($opinions->currentPage() - $i) < 3 || $i == $opinions->currentPage())
				<li class="waves-effect {{ $i == $opinions->currentPage() ? 'active brown' : '' }}"><a href="{{ $opinions->url($i) }}">{{ $i }}</a></li>
			@elseif (abs($opinions->currentPage() - $i) === 3)
				<li class="disabled">
					<span>...</span>
				</li>
			@endif
		@endfor
		@if ($opinions->hasMorePages())
			<li class="waves-effect"><a href="{{ $opinions->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
		@endif
	</ul>
	<table class="striped">
		<thead>
			<tr>
				<th>投票主題</th>
				<th>投票狀態</th>
				<th>發表時間</th>
				<th>操作</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($opinions as $opinion)
				<tr>
					<td>{{ $opinion->title }}</td>
					<td>{{ $opinion->status }}</td>
					<td>{{ $opinion->created_at }}</td>
					<td>
						<form action="{{ route('opinion.destroy', ['opinion' => $opinion->id ]) }}" method="POST">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn-floating waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="刪除">
								<i class="material-icons">delete</i>
							</button>
						</form>
					</td>
					<td>
						<a href="{{ route('opinion.show', ['opinion' => $opinion->id ]) }}" class="btn waves-effect waves-light brown tooltipped" data-delay="50" data-tooltip="查看貼文">
							查看
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endif