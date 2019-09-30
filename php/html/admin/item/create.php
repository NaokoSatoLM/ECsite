<?php
session_start();

include '/var/www/html/utils/common.php';
include '/var/www/html/utils/database.php';
include '/var/www/html/utils/render.php';
include '/var/www/html/utils/define.php';
//DB接続
$db = dbconnect();

$number = $_SESSION['number'];
$type = $_SESSION['type'];
$about = $_SESSION['about'];
$maker = $_SESSION['maker'];
$cost = $_SESSION['cost'];
$selling_price = $_SESSION['selling_price'];
$img = $_SESSION['img'];

if($_SERVER['REQUEST_METHOD'] != "POST"){
    //ここからHTML出力
    $render = new Render() ;
    $render->title = '商品価格新規追加';

    //もしセッション変数に入ってなければ入力用の空欄を出す
    //セッション変数があればエラー内容と入力を促す
    if($_SESSION['number'] == null){
        $instruct = "各空欄に入力してください";
    }else{        
        $instruct = "入力に誤りがあります" ;
    }
    $tbody =
    <<<HTML
    $instruct 
    <tr>
        <td>
            <input type="text" name="number" value="{$_SESSION['number']}" required/>
        </td>
        <td>
            <input type="text" name="type" value="{$_SESSION['type']}" required>
        </td>
        <td>
            <input type="text" name="about" value="{$_SESSION['about']}" maxlength="255" required/>
        </td>
        <td>
            <input type="text" name="maker" value="{$_SESSION['maker']}" required/>
        </td>
        <td>
            <input type="text" name="cost" value="{$_SESSION['cost']}" required/>
        </td>
        <td>
            <input type="text" name="selling_price" value="{$_SESSION['selling_price']}" value="{$_SESSION['img']}" required/>
        </td>
        <td>
            <input type="text" name="img"  value="{$_SESSION['img']}" />
            <input type="file" name="heel_file" size="30" > 
        </td>
    </tr>
    HTML;

    //タイトル部分
    $title = '<h1>PLEASER -登録画面</h1>';
    $table = renderTable(ITEM_TABLE_HEADER_CREATE,$tbody);
    $form = <<<HTML
        <form action="" method="POST" ENCTYPE="MULTIPART/FORM-DATA">
            $table
        <input type="submit" value="登録"></form>
    HTML;

    $render->body =$title . $form ;
    $render->renderHTML();

    //エラー出力
    if($_SESSION['error_message']){
        echo $_SESSION['error_message'] ;
    }
    session_destroy();

} elseif($_SERVER['REQUEST_METHOD'] == "POST") {

    //POSTで受け取っていれば登録のクエリを発行して登録を完了させる
    // $db = dbconnect();
     // print var_dump($_FILES);

    //POSTできた情報をセッション関数にする
    $_SESSION['number'] = $_POST['number'];
    $_SESSION['type'] = $_POST['type'];
    $_SESSION['about'] = $_POST['about'];
    $_SESSION['maker'] = $_POST['maker'];
    $_SESSION['cost'] = $_POST['cost'];
    $_SESSION['selling_price'] = $_POST['selling_price'];
    $_SESSION['img'] = $_POST['img'];

    //クエリ発行
    $sql = <<< EOT
    INSERT INTO
        items
    (
        number,
        type,
        about,
        maker,
        cost,
        selling_price,
        img
    )
    VALUES
    (
        '{$_POST['number']}',
        '{$_POST['type']}',
        '{$_POST['about']}',
        '{$_POST['maker']}',
        '{$_POST['cost']}',
        '{$_POST['selling_price']}',
        '{$_POST['img']}'
    )
    EOT;

    $result = $db->query($sql);
    $_SESSION['error'] = $db->error;
    $_SESSION['error_message'] = $db->errno.$db->error ;
    $_SESSION['err_message'] = "エラーメッセージ:".$_SESSION['error']."<br>";
        
        // echo $_SESSION['error']."★";
        // echo $_SESSION['error_message']."◆";
        // echo $_SESSION['err_message']."¶";

     //データベースでエラーが出れば前の画面に遷移
     if(!$result){
        header('Location: create.php');
        exit();
        

    } else {
        //エラーなければ登録処理すすめる
        //HTML出力
        $render = new render();
        $render->title ='商品登録 完了';

        //画像imageの重複を避けるためフォルダにかぶっていない画像番号をつけるようにする
        // $dir = 'admin/item/image/*' ;
        $filelist = glob('/var/www/html/admin/item/image/*') ; //フォルダの中のすべての画像をとってこれている
        // var_dump($filelist) ;

        $img = $_FILES['heel_file']['name'] ; //POSTSのファイル名取得
        // echo $img ;

        // $filepath = pathinfo( $filelist ) ;
        $img_name = array();
        foreach($filelist as $value){
            $filepath = pathinfo($value); 
            $img_name[] = $filepath['filename'].'.'.$filepath['extension'] ;
            // echo $img_name .'<br>'; example "heel1.jpg" などの形で出てくる
        }

        $i = 1 ;     //初期化
        $filepath = pathinfo($img); 
        while(in_array($img , (array)$img_name)){
                //同じ名前があれば番号つけて処理を続ける
                $img =$filepath['filename'].$i.'.'.$filepath['extension'] ;
                $i++ ;    
        }
        echo $img.'の名前でフォルダに登録しています' ; 
        
        //画像のアップロードの処理
        //画像の保存先
        $upload = '/var/www/html/admin/item/image/'.$img;
        if(move_uploaded_file($_FILES['heel_file']['tmp_name'], $upload)){
            echo 'アップロード完了';
        }else{
            echo 'アップロード失敗'; 
        }
        
        $aiueo = <<< HTML
            <h1>登録完了</h1>
            <p>登録が完了しました。</p>
            <form action="/admin/item/list.php" method="GET">
                <input type="submit" value="一覧に戻る" />
            </form>
        HTML;

        $render->body = $aiueo;
        $render->renderHTML();
        
        //セッション終了
        session_destroy();
    }
}

?>

