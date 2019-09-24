<?php
include '/var/www/html/utils/common.php';
include '/var/www/html/utils/database.php';
include '/var/www/html/utils/render.php';
include '/var/www/html/utils/define.php';

// GETでもPOSTでもおっけー
// method_prohibit('POST');

$db = dbconnect();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    // クエリ発行
    $sql = <<< EOT
        SELECT
            items.number,
            items.type,
            items.about,
            items.maker,
            items.cost,
            items.selling_price
        FROM
            items
        WHERE
            items.id = $id
    EOT;
    $result = $db->query($sql);

    // HTML出力
    $render = new Render();
    $render->title = '在庫管理 - 修正';
    $title = '<h1>PLEASER JAPAN 修正画面</h1>';
    // テーブル出力
    while ($row = $result->fetch_assoc()) {
        $tbody .= <<< HTML
        <tr>
            <td>{$row['number']}</td>
            <td>
                <input type="text" name="type" value="{$row['type']}" />
            </td>
            <td>
                <textarea type="text" name="about" >{$row['about']}</textarea>
            </td>
            <td>
                <input type="text" name="maker" value="{$row['maker']}" />
            </td>
            <td>
                <input type="text" name="cost" value="{$row['cost']}" />
            </td>
            <td>
                 <input type="text" name="selling_price" value="{$row['selling_price']}" />
             </td>
        </tr>
        HTML;
    }
    $table = renderTable(ITEM_TABLE_HEADER_CREATE, $tbody);
    $form = <<< HTML
    <form action="" method="POST">
        $table
        <input type="hidden" name="id" value="$id">
        <input type="submit" value="登録" />
    </form>
    HTML;

    $render->body = $title . $form;

    $render->renderHTML();

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // アップデート処理
    $sql = <<< EOT
    UPDATE
        items
    SET
        type = '{$_POST['type']}',
        about = '{$_POST['about']}',
        maker= '{$_POST['maker']}',
        cost = '{$_POST['cost']}',
        selling_price = '{$_POST['selling_price']}'
    WHERE
        items.id = {$_POST['id']}
    EOT;

    $result = $db->query($sql);
    echo $sql ;

    // HTML出力
    $render = new Render();
    $render->title = '在庫管理 - 修正完了';

    $body = <<< HTML
    <h1>修正完了</h1>
    <p>修正が完了しました。</p>
    <form action="/admin/item/list.php" method="GET">
        <input type="submit" value="一覧に戻る" />
    </form>
    HTML;

    $render->body = $body;
    $render->renderHTML();
}

?>
