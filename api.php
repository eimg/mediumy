<?php
/* === Configs === */
$dbhost = "127.0.0.1";
$dbuser = "root";
$dbpass = "";
$dbname = "mediumy";

/* === HTML Purifier === */
include("libs/html-purifier/HTMLPurifier.auto.php");

/* === DB Connection === */
try {
    $db = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $db->query("SET NAMES utf8");
} catch(PDOException $e) {
    error($e->getMessage());
}

/* === Action Handler === */
if(!isset($_REQUEST['action'])) {
    error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
}

switch($_REQUEST['action']) {
    case "all":
        get_all_posts();
        break;
    case "get":
        get_one_post();
        break;
    case "new":
        new_post();
        break;
    case "add":
        add_post();
        break;
    case "update":
        update_post();
        break;
    case "delete":
        delete_post();
        break;
    case "verify":
        verify();
        break;
    case "login":
        login();
        break;
    case "register":
        register();
        break;
    case "profile":
        update_profile();
        break;
    case "password":
        update_password();
        break;
    case "photo":
        upload_photo();
        break;
    case "upload":
        upload_image();
        break;
    case "comments":
        get_comments();
        break;
    case "comment":
        add_comment();
        break;
    case "deleteComment":
        delete_comment();
        break;
    case "favorite":
        add_favorite();
        break;
    case "unfavorite":
        remove_favorite();
        break;
    default:
        error("Action not found");
}

/* === Functions === */
function get_all_posts() {
    global $db;

    if(isset($_GET['q'])) {
        $keyword = $_GET['q'];
    } else {
        $keyword = false;
    }

    try {
        if($keyword) {
            $keyword = "%$keyword%";
            $result = $db->prepare("SELECT posts.title, posts.hash, posts.created_at, posts.feature, users.author, users.photo FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.title LIKE :keyword OR posts.body LIKE :keyword ORDER BY posts.created_at DESC");
            $result->execute([':keyword' => $keyword]);
        } else {
            $result = $db->query("SELECT posts.title, posts.hash, posts.created_at, posts.feature, users.author, users.photo FROM posts LEFT JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");
        }

        if(!$result->rowCount()) {
            error("ရလဒ်မရှိပါ");
        }

        $rows = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }

        echo json_encode($rows);
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function get_one_post() {
    global $db;

    if(!isset($_GET['hash'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    $hash = $_GET['hash'];

    try {
        $result = $db->query("SELECT posts.*, users.author, users.description, users.photo FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.hash = '$hash'", PDO::FETCH_ASSOC);

        if($row = $result->fetch()) {
            $post_id = $row['id'];
            $comments = $db->query("SELECT COUNT(*) AS count FROM comments WHERE post_id='$post_id'", PDO::FETCH_ASSOC);
            $comment_count = $comments->fetch();

            $row['comments'] = $comment_count['count'];
            echo json_encode($row);
        } else {
            error("ရလဒ်မရှိပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function new_post() {
    global $db;

    if(!isset($_COOKIE['user_id']) or
       !isset($_COOKIE['token'])) {
        error("ဆောင်ရွက်ခွင့်မပြုပါ");
    }

    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    try {
        $result = $db->prepare("SELECT * FROM users WHERE id=? AND token=?");
        $result->execute([ $user_id, $token ]);

        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode($row);
        } else {
            error("ရေးသားရန်ခွင့်ပြုချက်မရှိပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function update_post() {
    global $db;

    if(!isset($_POST['title']) or
       !isset($_POST['body']) or
       !isset($_POST['id'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    if(!isset($_COOKIE['user_id']) or
       !isset($_COOKIE['token'])) {
        error("ဆောင်ရွက်ခွင့်မပြုပါ");
    }

    $id = esc($_POST['id']);
    $title = esc($_POST['title']);
    $body = safe($_POST['body']);

    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    try {
        $result = $db->prepare("SELECT * FROM users WHERE id=? AND token=?");
        $result->execute([ $user_id, $token ]);

        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // verification success
        } else {
            error("ပြင်ဆင်ရန်ခွင့်ပြုချက်မရှိပါ");
        }

        $feature = extract_feature($body);

        $result = $db->prepare("UPDATE posts SET title=?, body=?, modified_at=NOW(), feature=? WHERE user_id=? AND id=?");
        $result->execute([ $title, $body, $feature, $user_id, $id ]);

        if($result->rowCount()) {
            echo json_encode([ "msg" => "Post update successful" ]);
        } else {
            error("ပြင်ဆင်မှုသိမ်းဆည်းခြင်းမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function add_post() {
    global $db;

    if(!isset($_POST['title']) or
       !isset($_POST['body'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    if(!isset($_COOKIE['user_id']) or
       !isset($_COOKIE['token'])) {
        error("ဆောင်ရွက်ခွင့်မပြုပါ");
    }

    $title = esc($_POST['title']);
    $body = safe($_POST['body']);
    $hash = substr(sha1($title . time()), 0, 7);

    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    try {
        $result = $db->prepare("SELECT * FROM users WHERE id=? AND token=?");
        $result->execute([ $user_id, $token ]);

        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // verification success
        } else {
            error("ရေးသားရန်ခွင့်ပြုချက်မရှိပါ");
        }

        $feature = extract_feature($body);

        $result = $db->prepare("INSERT INTO posts (hash, title, body, user_id, created_at, modified_at, feature) VALUES (?, ?, ?, ?, NOW(), NOW(), ?)");
        $result->execute([ $hash, $title, $body, $user_id, $feature ]);

        if($result->rowCount()) {
            echo json_encode([ "hash" => $hash ]);
        } else {
            error("လွှင့်တင်ရန်သိမ်းဆည်းမှုမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function delete_post() {
    global $db;

    if(!isset($_POST['id'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    if(!isset($_COOKIE['user_id']) or
       !isset($_COOKIE['token'])) {
        error("ဆောင်ရွက်ခွင့်မပြုပါ");
    }

    $id = esc($_POST['id']);
    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    try {
        $result = $db->prepare("SELECT * FROM users WHERE id=? AND token=?");
        $result->execute([ $user_id, $token ]);

        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // verification success
        } else {
            error("ပယ်ဖျက်ရန်ခွင့်မပြုပါ");
        }

        $result = $db->prepare("DELETE FROM posts WHERE id=? AND user_id=?");
        $result->execute([ $id, $user_id ]);

        if($result->rowCount()) {
            $db->query("DELETE FROM comments WHERE post_id = $id");
            echo json_encode([ "msg" => "Post deleted" ]);
        } else {
            error("ပယ်ဖျက်မှုမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function verify() {
    global $db;

    if(!isset($_COOKIE['token']) or
       !isset($_COOKIE['user_id'])) {
        error("စီစစ်မှုမအောင်မြင်ပါ");
    }

    $token = $_COOKIE['token'];
    $user_id = $_COOKIE['user_id'];

    try {
        $result = $db->prepare("SELECT * FROM users WHERE id=? AND token=?");
        $result->execute([ $user_id, $token ]);

        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode($row);
        } else {
            error("စီစစ်မှုမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function login() {
    global $db;

    if(!isset($_POST['email']) or
       !isset($_POST['password'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    $email = esc($_POST['email']);
    $password = esc($_POST['password']);

    try {
        $result = $db->prepare("SELECT * FROM users WHERE email=?");
        $result->execute([ $email ]);

        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if(!password_verify($password, $row['password'])) {
                error("ပက်စ်ဝပ်မမှန်ပါ");
            } else {
                $id = $row['id'];
                $token = password_hash(rand(0, 9999999) . time(), PASSWORD_DEFAULT);
                $store = $db->query("UPDATE users SET token ='$token' WHERE id = $id");
                if($store) {
                    setcookie("token", $token, time() + (3600 * 24 * 7));
                    setcookie("user_id", $id, time() + (3600 * 24 * 7));
                    $row['token'] = $token;
                    echo json_encode($row);
                } else {
                    error("တိုကင်သိမ်းဆည်းမှုမအောင်မြင်ပါ");
                }
            }
        } else {
            error("ရလဒ်မရှိပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function register() {
    global $db;

    if(!isset($_POST['author']) or
       !isset($_POST['email']) or
       !isset($_POST['password'])
    ) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    $author = esc($_POST['author']);
    $email = esc($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $result = $db->prepare("SELECT email FROM users WHERE email=?");
        $result->execute([ $email ]);

        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
            error("အီးမေးလ်လိပ်စာတူ ရှိနှင့်ပြီးဖြစ်နေသည်");
        }

        $result = $db->prepare("INSERT INTO users (author, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $result->execute([ $author, $email, $password ]);

        if($result->rowCount()) {
            echo json_encode([ "error" => 0, "msg" => "Register successful" ]);
        } else {
            error("မှတ်ပုံတင်ခြင်း မအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function update_profile() {
    global $db;

    if(!isset($_POST['author']) or
       !isset($_POST['description']) or
       !isset($_POST['email'])
    ) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    if(!isset($_COOKIE['user_id']) or
       !isset($_COOKIE['token'])) {
        error("ဆောင်ရွက်ခွင့်မပြုပါ");
    }

    $author = esc($_POST['author']);
    $description = esc($_POST['description']);
    $email = esc($_POST['email']);

    $id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    try {
        $result = $db->prepare("SELECT email FROM users WHERE id <> $id AND email=?");
        $result->execute([ $email ]);

        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
            error("အီးမေးလ်လိပ်စာတူ ရှိနှင့်ပြီးဖြစ်နေသည်");
        }

        $result = $db->prepare("UPDATE users SET author=?, description=?, email=? WHERE id=? AND token=?");
        $result->execute([ $author, $description, $email, $id, $token ]);

        if($result->rowCount()) {
            echo json_encode([ "msg" => "Profile update successful" ]);
        } else {
            error("ပရိုဖိုင်ပြင်ခြင်းမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function update_password() {
    global $db;

    if(!isset($_POST['password'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    if(!isset($_COOKIE['user_id']) or
       !isset($_COOKIE['token'])) {
        error("ဆောင်ရွက်ခွင့်မပြုပါ");
    }

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];
    $new_token = password_hash(rand(0, 9999999) . time(), PASSWORD_DEFAULT);

    try {
        $result = $db->prepare("UPDATE users SET password=?, token=? WHERE id=? AND token=?");
        $result->execute([ $password, $new_token, $id, $token ]);

        if($result->rowCount()) {
            setcookie("token", $new_token, time() + (3600 * 24 * 7));
            setcookie("user_id", $id, time() + (3600 * 24 * 7));
            echo json_encode([ "msg" => "Password update successful" ]);
        } else {
            error("ပက်စ်ဝပ်ပြင်ခြင်းမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function upload_photo() {
    global $db;

    if(!isset($_FILES["photo"])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    if(!isset($_COOKIE['user_id']) or
       !isset($_COOKIE['token'])) {
        error("ဆောင်ရွက်ခွင့်မပြုပါ");
    }

    $name = md5(rand(0, 999999) . time()) . ".jpg";
    $tmp = $_FILES["photo"]["tmp_name"];
    generate_thumb($tmp, "media/profile/$name", 150, 150);

    $id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    try {
        $result = $db->prepare("UPDATE users SET photo=? WHERE id=? AND token=?");
        $result->execute([ $name, $id, $token ]);

        if($result->rowCount()) {
            $result = $db->prepare("SELECT * FROM users WHERE id=? AND token=?");
            $result->execute([ $id, $token ]);
            $row = $result->fetch(PDO::FETCH_ASSOC);

            echo json_encode($row);
        } else {
            error("ဓာတ်ပုံသိမ်းဆည်းခြင်းမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function upload_image() {
    if(!isset($_FILES["files"])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    if(!isset($_COOKIE['user_id']) or
       !isset($_COOKIE['token'])) {
        error("ဆောင်ရွက်ခွင့်မပြုပါ");
    }

    $result = [];
    foreach($_FILES["files"]["tmp_name"] as $tmp) {
        $name = md5(rand(0, 999999) . time()) . ".jpg";
        generate_thumb($tmp, "media/post/$name", 760, 760);
        $result[] = [ "url" => "media/post/$name" ];
    }

    echo json_encode(["files" => $result]);
}

function get_comments() {
    global $db;

    if(!isset($_GET['id'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    $id = $_GET['id'];

    try {
        $result = $db->prepare("SELECT * FROM comments WHERE post_id = ?");
        $result->execute([ $id ]);

        if(!$result->rowCount()) {
            error("ရလဒ်မရှိပါ");
        }

        $rows = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }

        echo json_encode($rows);
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function add_comment() {
    global $db;

    if(!isset($_POST['comment']) or
       !isset($_POST['post_id'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    $auth = false;
    if(isset($_COOKIE['user_id']) and
       isset($_COOKIE['token'])) {
        $auth = true;
        $user_id = $_COOKIE['user_id'];
        $token = $_COOKIE['token'];
    }

    $comment = esc($_POST['comment']);
    $post_id = esc($_POST['post_id']);

    try {
        $author_name = "";
        $photo = "";
        $author_id = 0;

        if($auth) {
            $result = $db->prepare("SELECT * FROM users WHERE id=? AND token=?");
            $result->execute([ $user_id, $token ]);

            if($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $author_name = $row['author'];
                $photo = $row['photo'];
                $author_id = $row['id'];
            }
        } else {
            $author_name = isset($_POST['author_name']) ? $_POST['author_name'] : "အမည်မဖော်လိုသူ";
        }

        $result = $db->prepare("INSERT INTO comments (comment, post_id, user_id, author_name, photo, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $result->execute([ $comment, $post_id, $author_id, $author_name, $photo ]);

        if($result->rowCount()) {
            echo json_encode([ "msg" => "မှတ်ချက်ထည့်သွင်းပြီးပါပြီ" ]);
        } else {
            error("မှတ်ချက်ထည့်သွင်းခြင်းမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function delete_comment() {
    global $db;

    if(!isset($_POST['id'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    if(!isset($_COOKIE['user_id']) or
       !isset($_COOKIE['token'])) {
        error("ဆောင်ရွက်ခွင့်မပြုပါ");
    }

    $id = esc($_POST['id']);
    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    try {
        $result = $db->prepare("SELECT * FROM users WHERE id=? AND token=?");
        $result->execute([ $user_id, $token ]);

        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // verification success
        } else {
            error("မှတ်ချက်ပယ်ဖျက်ရန်ခွင့်မပြုပါ");
        }

        $result = $db->prepare("DELETE FROM comments WHERE id=?");
        $result->execute([ $id ]);

        if($result->rowCount()) {
            echo json_encode([ "msg" => "Comment deleted" ]);
        } else {
            error("မှတ်ချက်ပယ်ဖျက်မှုမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function add_favorite() {
    global $db;

    if(!isset($_POST['hash'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    $hash = esc($_POST['hash']);

    try {
        $result = $db->prepare("UPDATE posts SET reactions=reactions+1 WHERE hash=?");
        $result->execute([ $hash ]);

        if($result->rowCount()) {
            echo json_encode([ "msg" => "Added favorite" ]);
        } else {
            error("ဖေးဘရိတ်ပြုလုပ်ခြင်းမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

function remove_favorite() {
    global $db;

    if(!isset($_POST['hash'])) {
        error("ဆက်သွယ်ပုံနည်းစနစ်မမှန်ပါ");
    }

    $hash = esc($_POST['hash']);

    try {
        $result = $db->prepare("UPDATE posts SET reactions=reactions-1 WHERE hash=?");
        $result->execute([ $hash ]);

        if($result->rowCount()) {
            echo json_encode([ "msg" => "Removed favorite" ]);
        } else {
            error("ဖေးဘရိတ်ပယ်ထုတ်ခြင်းမအောင်မြင်ပါ");
        }
    } catch (PDOException $e) {
        error($e->getMessage());
    }
}

/* === Helpers === */
function generate_thumb($source_image_path, $thumbnail_image_path, $result_width, $result_height) {
    define('THUMBNAIL_IMAGE_MAX_WIDTH', $result_width);
    define('THUMBNAIL_IMAGE_MAX_HEIGHT', $result_height);

    if(!file_exists($source_image_path)) {
        error("ဖိုင်မရှိပါ");
    }

    if(!getimagesize($source_image_path)) {
        error("ဤဖိုင်အမျိုးအစားကိုလက်မခံပါ");
    }

    list(
        $source_image_width,
        $source_image_height,
        $source_image_type
    ) = getimagesize($source_image_path);

    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image_path);
            break;
        default:
            error("ဤဖိုင်အမျိုးအစားကိုလက်မခံပါ");
    }

    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = THUMBNAIL_IMAGE_MAX_WIDTH / THUMBNAIL_IMAGE_MAX_HEIGHT;

    if ($source_image_width <= THUMBNAIL_IMAGE_MAX_WIDTH &&
        $source_image_height <= THUMBNAIL_IMAGE_MAX_HEIGHT) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) (THUMBNAIL_IMAGE_MAX_HEIGHT * $source_aspect_ratio);
        $thumbnail_image_height = THUMBNAIL_IMAGE_MAX_HEIGHT;
    } else {
        $thumbnail_image_width = THUMBNAIL_IMAGE_MAX_WIDTH;
        $thumbnail_image_height = (int) (THUMBNAIL_IMAGE_MAX_WIDTH / $source_aspect_ratio);
    }

    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);

    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);

    imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    return true;
}

function extract_feature($html) {
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $imgs = $doc->getElementsByTagName('img');
    if($imgs->length > 0) {
        return $imgs[0]->getAttribute('src');
    }

    return "";
}

function error($msg) {
    echo json_encode([ "error" => 1, "msg" => $msg ]);
    exit(1);
}

function esc($data) {
    return strip_tags($data);
}

function safe($data) {
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);

    // Replacing <figure> and <figoption> with <div>
    $data = preg_replace("/<figure[^>]*\>/i", "<div class=\"figure\" contenteditable=\"false\">", $data);
    $data = preg_replace("/<figcaption[^>]*\>/i", "<div class=\"figcaption\" contenteditable=\"true\">", $data);
    $data = str_replace("</figure>", "</div>", $data);
    $data = str_replace("</figcaption>", "</div>", $data);

    return $purifier->purify($data);
}
