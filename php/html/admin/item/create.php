<?php
include '/var/www/html/utils/common.php';
include '/var/www/html/utils/database.php';
include '/var/www/html/utils/render.php';
include '/var/www/html/utils/define.php';

if($_SERVER['REQUEST_METHOD'] != "POST"){
//ここからHTML出力
    $render = new Render() ;
    $render->title = '商品価格新規追加';
    
//入力用の空欄を出す
$tbody=<<<HTML
   <tr>
        <td>
            <input type="text" name="number" />
        </td>
        <td>
            <input type="text" name="type" />
        </td>
        <td>
            <input type="text" name="about" />
        </td>
        <td>
            <input type="text" name="maker" />
        </td>
        <td>
            <input type="text" name="cost" />
        </td>
        <td>
            <input type="text" name="selling_price" />
        </td>
    </tr>
HTML;

    //タイトル部分
    $title = '<h1>PLEASER -登録画面</h1>';
    $table = renderTable(ITEM_TABLE_HEADER_CREATE,$tbody);
    $form = <<<HTML
        <form action="" method="POST">
            $table
        <input type="submit" value="登録"></form>
    HTML;

    $render->body =$title . $form ;
    $render->renderHTML();

}else{

//POSTで受け取っていれば登録のクエリを発行して登録を完了させる
$db = dbconnect();
//クエリ発行
$sql = <<< HTML
INSERT INTO
    items
(
    number,
    type,
    about,
    maker,
    cost,
    selling_price
)
VALUES
(
    '{$_POST['number']}',
    '{$_POST['type']}',
    '{$_POST['about']}',
    '{$_POST['maker']}',
    '{$_POST['cost']}',
    '{$_POST['selling_price']}'
)
HTML;

echo $_POST['number'];
echo $_POST['type'];
echo $_POST['about'];
echo $_POST['maker'];
echo $_POST['cost'];
echo '★★★★★★';
echo $_POST['selling_price'];
echo $sql ;



$result = $db->query($sql);

//HTML出力
$render = new render() ;
$render->title ='商品登録　完了';

$body=<<<HTML
<h1>登録完了</h1>
    <p>登録が完了しました。</p>
    <form action="/admin/item/list.php" method="GET">
        <input type="submit" value="一覧に戻る" />
    </form>
HTML;

 $render->body = $body;
 $render->renderHTML();


}

    
?>