<div class="container">
@if ($errors->any())
    <div class="card-panel red lighten-1 white-text animate__animated animate__fadeInDown">
        <ul class="browser-default">
            @foreach ($errors->all() as $error)
                <li><i class="material-icons left">error_outline</i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="card-panel red lighten-1 white-text animate__animated animate__fadeInDown">
        <i class="material-icons left">error</i>
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="card-panel green lighten-1 white-text animate__animated animate__fadeInDown">
        <i class="material-icons left">check_circle</i>
        {{ session('success') }}
    </div>
@endif
</div>
