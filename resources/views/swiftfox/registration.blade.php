@extends('layouts.app')

@section('content')

<div id="app">

    @include('component.tool')

    @include('component.navigation')

    @include('component.serve.message')

    @include('component.form.login')

    @include('component.form.register')

    <br>

    <div class="container">
        <div class="row">
            <div class="col m12">
                <ul class="tabs">
                    <li class="tab col m6"><a href="#test1">登入帳號</a></li>
                    <li class="tab col m6"><a href="#test2">註冊帳號</a></li>
                </ul>
            </div>
            <div id="test1" class="col m12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m6">
                                <img id="LOGO" class="responsive-img" alt="SWIFT FOX LOGO" src="{{ asset('images/SWIFT FOX LOGO.png') }}">
                            </div>
                            <div class="col s12 m6">
                                <form action="{{ route('login') }}" method="post" name="LoginForm">
                                    @csrf
                                    <h4 class="center-align"><b>登入帳號</b></h4>
                                    <div class="row">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">account_circle</i>
                                                <input value="{{ old('account') }}" name="account" id="icon_prefix" type="text" class="validate">
                                                <label for="icon_prefix">帳號</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">https</i>
                                                <input name="password" id="password" type="password" class="validate">
                                                <label for="icon_telephone">密碼</label>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br><br><br><br>
                                    <button class="waves-effect waves-light btn-large brown right" type="submit"><b>登入</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="test2" class="col m12">
                <div class="card">
                    <div class="card-content">
                        <form action="{{ route('register') }}" method="post" name="RegisterForm">
                            @csrf
                            <div class="modal-content">
                                <h4 class="center-align"><b>註冊帳號</b></h4>
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
                            <button class="waves-effect waves-light btn-large brown right" type="submit"><b>註冊</b></button>
                            <br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <router-view></router-view>

</div>

<br>

@include('component.contact')

<br>

@include('component.footer')

@endsection
