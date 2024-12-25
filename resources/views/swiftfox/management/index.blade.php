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

	<br>
	
	@include('component.footer')
	
@endsection

@section('scripts')

<script type="text/javascript">

    $('#bulletinForm').on('submit', function(event) {
        event.preventDefault();

        var title = $('#bulletin-title').val();
        var content = $('#bulletin-content').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('bulletin.store') }}",
            method: "POST",
            data: {
                title: title,
                content: content,
                _token: _token
            },
            success: function(response) {
                if (response.success) {
                    M.toast({html: response.message});
                } else {
                    M.toast({html: response.message});
                }
            }
        });
    });

	$('#clubForm').on('submit', function(event) {
		event.preventDefault();

		var title = $('#club-title').val();
		var tag = $('#tag').val();
		var teacher = $('#teacher').val();
		var director = $('#director').val();
		var vice_director = $('#vice_director').val();
		var content = $('#club-content').val();
		var _token = $('input[name="_token"]').val();

    	$.ajax({
			url: "{{ route('club.store') }}",
			method: "POST",
			data: {
				title: title,
				tag: tag,
				teacher: teacher,
				director: director,
				vice_director: vice_director,
				content: content,
				_token: _token
			},
			success: function(response) {
				if (response.success) {
					M.toast({html: response.message});
				} else {
					M.toast({html: response.message});
				}
			}
		});
	});

	$('#activityForm').on('submit', function(event) {
		event.preventDefault();

		var title = $('#activity-title').val();
		var content = $('#activity-content').val();
		var location = $('#activity-location').val();
		var date = $('#activity-date').val();
		var url = $('#activity-url').val();
		var _token = $('input[name="_token"]').val();

    	$.ajax({
			url: "{{ route('activity.store') }}",
			method: "POST",
			data: {
				title: title,
				content: content,
				location: location,
				date: date,
				url: url,
				_token: _token
			},
			success: function(response) {
				if (response.success) {
					M.toast({html: response.message});
				} else {
					M.toast({html: response.message});
				}
			}
		});
	});

</script>

@endsection
