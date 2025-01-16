<div class="fixed-action-btn click-to-toggle">
    <a class="btn-floating btn-large red">
        <i class="large material-icons brown">menu</i>
    </a>
    <ul>
        <li>
            <a href="{{route('home.index')}}" class="btn-floating yellow tooltipped modal-trigger" data-position="top" data-tooltip="我的小屋">
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
