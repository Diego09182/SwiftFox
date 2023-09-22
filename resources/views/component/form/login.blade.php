<div id="modal1" class="modal">
    <form action="{{ route('login') }}" method="post" name="LoginForm">
        <div class="modal-content">
            @csrf
            <h4 class="center-align">系統登入</h4>
            <div class="row">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">account_circle</i>
                    <input name="account" id="icon_prefix" type="text" class="validate">
                    <label for="icon_prefix">帳號</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">https</i>
                    <input name="password" id="password" type="password" class="validate">
                    <label for="icon_telephone">密碼</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class=" modal-action modal-close waves-effect waves-green btn-flat">關閉</a>
            <button class="waves-effect waves-light btn brown" type="submit">登入</button>
        </div>
    </form>
</div>