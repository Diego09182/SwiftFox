<nav class="lighten-1 brown" role="navigation" id="navigation">
    <div class="nav-wrapper container">
        @guest
            <a id="logo-container" class="brand-logo center">
                <b>
                    <router-link to='/home'>Swift Fox</router-link>
                </b>
            </a>
        @endguest
        @auth
            <a id="logo-container" href="{{ route('main')}}" class="brand-logo center">
                <b>
                    Swift Fox
                </b>
            </a>
        @endauth
        @guest
            <ul class="left hide-on-med-and-down">
                <b>
                    <li><a class="waves-effect"><router-link to='/about'>關於網站</router-link></a></li>
                    <li><a class="waves-effect"><router-link to='/disclaimer'>網站聲明</router-link></a></li>
                </b>
            </ul>
        @endguest
        @auth
            <ul class="left hide-on-med-and-down">
                <b>
                    <li><a>{{ Auth::user()->name }}</a></li>
                    <li><a>{{ Auth::user()->account }}</a></li>
                </b>
            </ul>
            <ul class="right hide-on-med-and-down">
                <b>
                    <li><a href="{{route('profile.index')}}">個人資訊</a></li>
                    <li><a href="{{route('home.index')}}">個人檔案</a></li>
                    @if(Auth::user()->administration == 5)
                        <li><a href="{{route('management.index')}}">後台</a></li>
                    @endif
                </b>
            </ul>
        @endauth
        <a data-target="slide-out" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>
    </div>
</nav>
<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view">
            <div class="responsive-img" class="background">
                <img class="responsive-img" alt="SWIFT FOX LOGO" src="{{ asset('images/SWIFT FOX LOGO.png') }}">
            </div>
        </div>
    </li>
    @auth
        <li><a class="waves-effect"><i class="material-icons">info_outline</i>使用者資訊</a></li>
        <li><a class="waves-effect"><b>{{ Auth::user()->name }}</b></a></li>
        <li><a class="waves-effect"><b>{{ Auth::user()->account }}</b></a></li>
    @endauth
    @guest
        <li>
            <ul class="collapsible collapsible-accordion">
                <li><a><router-link to='/about'><p class="black-text"><b>關於網站</b><p></router-link></a></li>
                <li><a><router-link to='/disclaimer'><p class="black-text"><b>網站聲明</b><p></router-link></a></li>
            </ul>
        </li>
    @endguest
    <li><a class="waves-effect"><i class="material-icons">info_outline</i><b>開發者資訊</b></a></li>
    <li><a class="waves-effect"><b>開發者名稱:</b></a></li>
    <li><a class="waves-effect"><b>SSSS</b></a></li>
    <li><a class="waves-effect"><b>個人信箱:</b></a></li>
    <li><a class="waves-effect"><b>ssss.gladmasy@gmail.com</b></a></li>
</ul>