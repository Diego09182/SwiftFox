<div class="container">
    <div class="container">
        <div class="center-align">
            <h3 class="tm-text-primary tm-section-title mb-4">公佈欄</h3>
        </div>
        @if ($bulletin)
			<div class="col s6 m6">
				<div class="card horizontal">
					<div class="card-stacked">
						<div class="card-content">
							<h4>
								<blockquote>
									{{$bulletin->title}}
								</blockquote>
							</h4>
							<hr>
							<h4>
								<blockquote>
									{{$bulletin->content}}
								</blockquote>
							</h4>
							<br><br><br><br><br>
							<h4 class="right">
								{{$bulletin->created_at}}
							</h4>
						</div>
					</div>
				</div>
			</div>
        @else
			<div class="col s6 m6">
					<div class="card horizontal">
						<div class="card-stacked">
							<div class="card-content">
								<h4>
									<blockquote>
										目前沒有公告
									</blockquote>
								</h4>
								<hr>
								<h4>
									<blockquote>
										目前沒有公告
									</blockquote>
								</h4>
								<br><br><br><br><br>
							</div>
						</div>
					</div>
				</div>
       		@endif
    </div>
</div>