<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <title></title>
    <link rel="stylesheet" href="{{ asset('/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <!--スマホ,タブレット対応-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!--サイトのアイコン指定-->
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <!--iphoneのアプリアイコン指定-->
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    <!--OGPタグ/twitterカード-->
</head>
<body>
    <header>
        <div id = "head">
        <h1><a href = "http://127.0.0.1:8000/top"><img src="{{ asset('/images/main_logo.png') }}" class ="dawnlogo"></a></h1>
            <!-- アコーディオンメニュー -->
            <div class="accordion">
                <label class ="accordion-title", for ="accordion-title">
                    <p>{{ Auth::user()->username }}さん</p>
                    <span class="arrow"> ∨ </span>
                    <img class="myicon" src="{{ asset('/images/dawn.png') }}"></label>
                <input type="checkbox" id="accordion-title" />
                <ul id="accordion-content">
                    <li><a href="/top">HOME</a></li>
                    <li><a href="/profile">プロフィール編集</a></li>
                    <li><a href="/logout">ログアウト</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div id="row">
        <div id="container">
            @yield('content')
        </div >
        <!-- サイドバー -->
        <div id="side-bar">
            <div id="side-bar-confirm">
                <p class="side-ffitem side-myname">{{ Auth::user()->username }}さんの</p>
                <div id="side-bar-confirm-follow">
                    <p class="side-ffitem">フォロー数</p>
                    <p class="side-count">{{ $auths -> followersCount() }}名</p>
                </div>

                <div id="side-bar-confirm-follow-list">
                    <p class="btn"><a href="/follow-list" class="side-btn">フォローリスト</a></p>
                </div>

                <div id="side-bar-confirm-follower">
                    <p class="side-ffitem">フォロワー数</p>
                    <p class="side-count">{{ $auths -> followsCount() }} 名</p>
                </div>

                 <div id="side-bar-confirm-follower-list">
                    <p class="btn"><a href="follower-list" class="side-btn">フォロワーリスト</a></p>
                </div>
            </div>
            <div id="side-bar-search">
                <p class="btn"><a href="search" class="side-btn">ユーザー検索</a></p>
            </div>
        </div>
    </div>
    <footer>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/js/modal.js') }}"></script>
</body>
</html>
