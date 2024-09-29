<div id="modal2" class="modal">
	<form action="{{ route('register') }}" method="post" name="RegisterForm">
		@csrf
		<div class="modal-content">
			<h4 class="center-align">註冊帳號</h4>
			<div class="row">
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">account_box</i>
					<input name="name" id="icon_prefix" type="text" class="validate">
					<label for="icon_prefix">姓名</label>
				</div>
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">date_range</i>
					<input name="birthday" type="text" id="icon_prefix" class="datepicker">
					<label for="icon_prefix">生日</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">account_circle</i>
					<input name="account" id="icon_prefix" type="text" class="validate">
					<label for="icon_prefix">註冊帳號</label>
				</div>
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">https</i>
					<input name="password" id="password" type="password" class="validate">
					<label for="password">註冊密碼</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">email</i>
					<input name="email" id="email" type="email" class="validate">
					<label for="email" data-error="wrong" data-success="right">電子信箱</label>
				</div>
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">stay_primary_portrait</i>
					<input name="cellphone" id="cellphone" type="tel" class="validate">
					<label for="telephone" data-error="wrong" data-success="right">行動電話</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">關閉</a>
			<button class="waves-effect waves-light btn brown" type="submit">註冊</button>
		</div>
	</form>
</div>