<div class="fixed-action-btn click-to-toggle">
    <a class="btn-floating btn-large brown z-depth-3">
        <i class="large material-icons text-lighten-4">menu</i>
    </a>
    <ul>
        <li>
            <a href="{{ route('home.index') }}"
               class="btn-floating amber darken-2 tooltipped z-depth-2"
               data-position="top"
               data-tooltip="個人檔案">
                <i class="material-icons">dashboard</i>
            </a>
        </li>
        <li>
            <a href="{{ route('profile.index') }}"
               class="btn-floating teal lighten-1 tooltipped z-depth-2"
               data-position="top"
               data-tooltip="個人資訊">
                <i class="material-icons">person</i>
            </a>
        </li>
        <li>
            <a href="{{ route('profile.redemptions') }}"
               class="btn-floating indigo lighten-1 tooltipped z-depth-2"
               data-position="top"
               data-tooltip="兌換紀錄">
                <i class="material-icons">history</i>
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}"
               class="btn-floating indigo lighten-1 tooltipped z-depth-2"
               data-position="top"
               data-tooltip="登出">
                <i class="material-icons">exit_to_app</i>
            </a>
        </li>
    </ul>
</div>

