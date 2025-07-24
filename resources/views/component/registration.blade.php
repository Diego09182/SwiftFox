<div class="container">
    <div class="row">
        <div class="col m12 animate__animated animate__fadeInDown animate__delay-0.5s">
            <ul class="tabs">
                <li class="tab col m6"><a href="#test1"><h5>登入帳號</h5></a></li>
                <li class="tab col m6"><a href="#test2"><h5>註冊帳號</h5></a></li>
            </ul>
        </div>
        <div id="test1" class="col m12 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m6">
                            <img id="LOGO" class="responsive-img" alt="SWIFT FOX LOGO" src="{{ asset('images/SWIFT FOX LOGO.png') }}">
                        </div>
                        <div class="col s12 m6 animate__animated animate__fadeInRight animate__delay-1s">
                            <form action="{{ route('login') }}" method="post" name="LoginForm">
                                @csrf
                                <h4 class="center-align"><b>登入帳號</b></h4>
                                <div class="row">
                                    <div class="input-field col s12 animate__animated animate__fadeInUp animate__delay-1s">
                                        <i class="material-icons prefix">account_circle</i>
                                        <input value="{{ old('account') }}" name="account" id="login_account" type="text" class="validate">
                                        <label for="login_account">帳號</label>
                                    </div>
                                    <div class="input-field col s12 animate__animated animate__fadeInUp animate__delay-1s">
                                        <i class="material-icons prefix">https</i>
                                        <input name="password" id="login_password" type="password" class="validate">
                                        <label for="login_password">密碼</label>
                                    </div>
                                </div>
                                <br><br><br><br><br><br><br><br>
                                <button class="waves-effect waves-light btn-large brown right animate__animated animate__zoomIn animate__delay-2s" type="submit"><b>登入</b></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="test2" class="col m12 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="card">
                <div class="card-content">
                    <form action="{{ route('register') }}" method="post" name="RegisterForm">
                        @csrf
                        <div class="modal-content">
                            <h4 class="center-align"><b>註冊帳號</b></h4>
                            <div class="row">
                                <div class="input-field col s12 m6 animate__animated animate__fadeInUp animate__delay-2s">
                                    <i class="material-icons prefix">account_box</i>
                                    <input name="name" id="name" type="text" class="validate">
                                    <label for="name">姓名</label>
                                </div>
                                <div class="input-field col s12 m6 animate__animated animate__fadeInUp animate__delay-2s">
                                    <i class="material-icons prefix">date_range</i>
                                    <input name="birthday" type="text" id="birthday" class="datepicker">
                                    <label for="birthday">生日</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m6 animate__animated animate__fadeInUp animate__delay-2s">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input name="account" id="register_account" type="text" class="validate">
                                    <label for="register_account">註冊帳號</label>
                                </div>
                                <div class="input-field col s12 m6 animate__animated animate__fadeInUp animate__delay-2s">
                                    <i class="material-icons prefix">https</i>
                                    <input name="password" id="register_password" type="password" class="validate">
                                    <label for="register_password">註冊密碼</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m6 animate__animated animate__fadeInUp animate__delay-2s">
                                    <i class="material-icons prefix">email</i>
                                    <input name="email" id="email" type="email" class="validate">
                                    <label for="email">電子信箱</label>
                                </div>
                                <div class="input-field col s12 m6 animate__animated animate__fadeInUp animate__delay-2s">
                                    <i class="material-icons prefix">stay_primary_portrait</i>
                                    <input name="cellphone" id="cellphone" type="tel" class="validate">
                                    <label for="cellphone">行動電話</label>
                                </div>
                            </div>
                        </div>
                        <button class="waves-effect waves-light btn-large brown right animate__animated animate__zoomIn animate__delay-3s" type="submit"><b>註冊</b></button>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
