<nav class="lighten-1 brown" role="navigation">
    <div class="nav-wrapper container">
        @guest
            <a id="logo-container" href="#" class="brand-logo center">
                <router-link to='/home'>SwiftFox</router-link>
            </a>
        @endguest
        @auth
            <a id="logo-container" href="{{ route('main')}}" class="brand-logo center">
                SwiftFox
            </a>
        @endauth
        <ul class="left hide-on-med-and-down">
            @guest
                <li><a href="#"><router-link to='/about'>關於網站</router-link></a></li>
                <li><a href="#"><router-link to='/disclaimer'>網站聲明</router-link></a></li>
            @endguest
            @auth
                <li><a href="#">{{ Auth::user()->name }}</a></li>
                <li><a href="#">{{ Auth::user()->account }}</a></li>
            @endauth
        </ul>
        <ul class="right hide-on-med-and-down">
            @auth
                <li><a href="{{route('profile.index')}}">個人資訊</a></li>
                <li><a href="{{route('home.index')}}">我的小屋</a></li>
                <li><a href="#">收藏庫</a></li>
            @endauth
        </ul>
        <a href="#" data-target="slide-out" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>
    </div>
</nav>
<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view">
            <div class="responsive-img" class="background">
                <img class="responsive-img" src="{{ asset('images/SWIFT FOX LOGO.png') }}">
            </div>
        </div>
    </li>
    @auth
        <li><a class="waves-effect"><i class="material-icons">info_outline</i>使用者資訊</a></li>
        <li><a class="waves-effect">{{ Auth::user()->name }}</a></li>
        <li><a class="waves-effect">{{ Auth::user()->account }}</a></li>
    @endauth
    @guest
        <li>
            <ul class="collapsible collapsible-accordion">
                <li><a href="#"><router-link to='/about'>關於網站</router-link></a></li>
                <li><a href="#"><router-link to='/disclaimer'>網站聲明</router-link></a></li>
            </ul>
        </li>
    @endguest
    <li><a class="waves-effect"><i class="material-icons">info_outline</i>開發者資訊</a></li>
    <li><a class="waves-effect">開發者:SSSS</a></li>
    <li><a class="waves-effect">信箱:ssss.gladmasy@gmail.com</a></li>
</ul>