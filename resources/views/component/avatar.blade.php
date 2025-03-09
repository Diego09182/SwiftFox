<div class="card">
    <div class="card-image">
        @if ($post->user->avatar_filename)
        <img class="materialboxed" src="{{ asset('storage/avatars/' . $post->user->avatar_filename) }}" alt="User Avatar">
        @else
        <img class="materialboxed" src="{{ asset('images/SWIFT FOX LOGO.png') }}" alt="Default Avatar">
        @endif
    </div>
    <div class="card-content">
        <div class="row">
            <a href="#modal2" class="modal-trigger btn-floating waves-effect waves-light brown right tooltipped" data-delay="50" data-tooltip="個人資料"><i class="material-icons">perm_identity</i></a>
        </div>
        <h5>使用者:</h5>
        <h5 class="center">{{ $post->user->account }}</h5>
    </div>
</div>
<ul class="collapsible" data-collapsible="accordion">
    <li>
        <div class="collapsible-header"><i class="material-icons">info</i>個人簡介</div>
        <div class="collapsible-body center">
            <p>{{ $post->user->info }}</p>
        </div>
    </li>
</ul>
