<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ဆောင်းပါး အတွေးအမြင်နှင့် စာတိုပေစများအား မြန်မာဘာသာဖြင့် ရေးသားနိုင်သော medium ပုံစံတူစနစ်">

    <title>Mediumy - မြန်မာဘာသာဆောင်းပါးများ</title>

    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/medium-editor/dist/css/medium-editor.min.css">
    <link rel="stylesheet" href="bower_components/medium-editor/dist/css/themes/beagle.css">
    <link rel="stylesheet" href="bower_components/medium-editor-insert-plugin/dist/css/medium-editor-insert-plugin.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tablet.css" media="(max-width: 1000px)">
    <link rel="stylesheet" href="css/mobile.css" media="(max-width: 600px)">
</head>
<body>
    <div class="progress"></div>
    <div class="container">
        <header>
            <div class="head-container">
                <div class="mobile-search">
                    <div>
                        <span class="fa fa-search"></span>
                        <input type="text" onkeydown="app.search(this, event)">
                    </div>
                    <span class="fa fa-close" onclick="$(this).parent().hide()"></span>
                </div>
                <div class="company">
                    <a href="https://mediumy.com/" class="company-logo">
                        <img src="img/logo.png" alt="">
                    </a>
                    <div class="company-name">
                        <a href="https://fairway.com.mm/">
                            Mediumy <small>- Beta</small>
                        </a>
                    </div>
                </div>
                <ul class="search-menu"></ul>
                <?php include("templates/search-menu.php") ?>
                <div class="menu-container">
                <ul class="menu">
                    <li><a href="#/">ပင်မစာမျက်နှာ</a></li>
                    <li onclick="app.toggleSubMenu(this)">
                        <span class="link">နည်းပညာများ <span class="fa fa-caret-down"></span></span>
                        <ul class="sub-menu">
                            <li><a href="https://yabwe.github.io/medium-editor/">Medium Editor</a></li>
                            <li><a href="http://linkesch.com/medium-editor-insert-plugin/">Medium Editor Insert Plugin</a></li>
                            <li><a href="http://fontawesome.io/">FontAwesome</a></li>
                            <li><a href="http://sammyjs.org/">sammy.js</a></li>
                            <li><a href="http://jquery.com/">jQuery</a></li>
                        </ul>
                    </li>
                    <li><a href="https://github.com/eimg/mediumy">ဒေါင်းလုပ်ရယူရန်</a></li>
                    <li><a href="https://eimaung.com/">ဖန်တီးသူ</a></li>
                </ul>
                </div>
            </div>
        </header>
        <div id="main">
            <!-- Pages -->
            <?php include("templates/list.php") ?>
            <?php include("templates/post.php") ?>

            <!-- Partials -->
            <?php include("templates/comment.php") ?>

            <!-- Models -->
            <div class="overlay"></div>
            <?php include("templates/login.php") ?>
            <?php include("templates/register.php") ?>
            <?php include("templates/profile.php") ?>
            <?php include("templates/password.php") ?>
        </div>
    </div>

    <input type="file" name="photo" id="photo-input" style="display: none">
    <div class="model-message"></div>
    <script type="text/x-template" id="model-message-template">
        <span class="fa fa-close" onclick="app.closeModelMessage()"></span>
        <div class="model-message-body">
            {{ message }}
            <div class="model-message-buttons">
                <button class="model-message-close" onclick="app.closeModelMessage()">{{close}}</button>
                {{#if confirm}}
                    <button class="model-message-yes"
                            onclick="{{action}}">{{yes}}</button>
                {{/if}}
            </div>
        </div>
    </script>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/medium-editor/dist/js/medium-editor.js"></script>
    <script src="bower_components/handlebars/handlebars.min.js"></script>
    <script src="bower_components/jquery-sortable/source/js/jquery-sortable-min.js"></script>
    <script src="bower_components/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <script src="bower_components/blueimp-file-upload/js/jquery.iframe-transport.js"></script>
    <script src="bower_components/blueimp-file-upload/js/jquery.fileupload.js"></script>
    <script src="bower_components/medium-editor-insert-plugin/dist/js/medium-editor-insert-plugin.min.js"></script>
    <script src="bower_components/medium-editor-autolist/dist/autolist.min.js"></script>
    <script src="bower_components/sammy/lib/min/sammy-latest.min.js"></script>
    <script src="bower_components/moment/min/moment.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
