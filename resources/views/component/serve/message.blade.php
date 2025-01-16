@if ($errors->any())
    <div class="card red center">
        <div class="card-content white-text">
            <ul>
                @foreach ($errors->all() as $error)
                    <li><h4>{{ $error }}</h4></li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="card red center">
        <div class="card-content white-text">
            <h4>{{ session('error') }}</h4>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="card green center">
        <div class="card-content white-text">
            <h4>{{ session('success') }}</h4>
        </div>
    </div>
@endif