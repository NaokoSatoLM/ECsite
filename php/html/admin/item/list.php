<?php
include '/var/www/html/utils/common.php';
include '/var/www/html/utils/database.php';
include '/var/www/html/utils/render.php';
include '/var/www/html/utils/define.php';

method_prohibit('POST');

    // GETパラメータ取得
    $number = $_GET['number'];

    //一覧を出す
    //itemsのテーブルから選択肢をとってくる
    $db = dbconnect();
    $sql = <<< EOT
    SELECT
        items.id,
        items.number,
        items.type,
        items.about,
        items.maker,
        items.cost,
        items.selling_price
    FROM
        items
    WHERE
        items.number like '%$number%'
    ORDER BY
        items.number
    EOT;
    $result = $db->query($sql);

    //ここからHTML出力
    $render = new Render() ;
    $render->title = '商品価格管理';

    //タイトル部分
    $title = '<h1>PLEASER -新規登録</h1>';

    //検索項目部分
    $search = <<< HTML
    <form action="" method="GET">
        <label for="number">Number:</label>
        <input type="text" id="number" name="number" />
        <input type="submit" value="検索" />
    </form>
HTML;

//新規登録フォームへの遷移
$create =  <<< HTML
<form action="/admin/item/create.php" method="GET">
    <input type="submit" value="新規登録">
</form>
HTML;

//テーブル部分
while ($row = $result->fetch_assoc()){
    $tbody .= <<<HTML
        <tr>
        <td>
            <form action="/admin/item/update.php" method="GET">
                <input type="hidden" name='id' value="{$row['id']}" />
                <input type="submit" value="修正" />
            </form>
            <form action="delete.php" method="GET">
                <input type="hidden" name='id' value="{$row['id']}" />
                <input type="submit" value="削除" />
            </form>
        </td>
        <td>{$row['number']}</td>
        <td>{$row['type']}</td>
        <td>{$row['about']}</td>
        <td>{$row['maker']}</td>
        <td>{$row['cost']}</td>
        <td>{$row['selling_price']}</td>
        
    </tr>
    HTML;
}

$table = renderTable(ITEM_TABLE_HEADER,$tbody);

$render->body = $title . $search . $create . $table;$render->renderHTML() ;   
?>




