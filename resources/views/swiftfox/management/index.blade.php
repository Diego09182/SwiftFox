@extends('layouts.app')

@section('content')

	@include('component.navigation')

	@include('component.serve.message')

	@include('component.logoutbanner')

	@include('component.toolbar')

    @include('component.managementlist')

    <div class="container">
		<div class="row">
			<div class="col m12">
				<ul class="tabs">
					<li class="tab col m3"><a href="#clubForm"><h5>創建社團</h5></a></li>
					<li class="tab col m3"><a href="#activityForm"><h5>創建活動</h5></a></li>
					<li class="tab col m3"><a href="#bulletinForm"><h5>創建公告</h5></a></li>
                    <li class="tab col m3"><a href="#prizeForm"><h5>創建獎品</h5></a></li>
				</ul>
			</div>
		</div>
	</div>

	<div id="clubForm" class="col m12">
		@include('component.form.club')
	</div>
	<div id="activityForm" class="col m12">
		@include('component.form.activity')
	</div>
    <div id="prizeForm" class="col m12">
		@include('component.form.prize')
	</div>
	<div id="bulletinForm" class="col m12">
		@include('component.form.bulletin')
	</div>

	<br><br><br>

	@include('component.footer')

@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoClose: true
        });
    });

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
        var formData = new FormData(event.target);
        $.ajax({
            url: "{{ route('club.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    M.toast({html: response.message});
                } else {
                    M.toast({html: response.message});
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var message = '';
                for (var key in errors) {
                    message += errors[key][0] + '<br>';
                }
                M.toast({html: message});
            }
        });
    });

    $('#activityForm').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(event.target);
        $.ajax({
            url: "{{ route('activity.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                M.toast({ html: response.message });
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var message = '';
                for (var key in errors) {
                    message += errors[key][0] + '<br>';
                }
                M.toast({html: message});
            }
        });
    });

</script>

@endsection
