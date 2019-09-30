<?php
include '/var/www/html/utils/common.php';
include '/var/www/html/utils/database.php';
include '/var/www/html/utils/render.php';
include '/var/www/html/utils/define.php';

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
            items.selling_price,
            items.img
        FROM
            items
        WHERE
            items.id = $id
    EOT;
    $result = $db->query($sql);

    // HTML出力
    $render = new Render();
    $render->title = '在庫管理 - 削除';
    $title = '<h1>PLEASER JAPAN 削除画面</h1>';

    // テーブル出力
    while ($row = $result->fetch_assoc()) {
        $tbody .= <<< HTML
        <tr>
            <td>{$row['number']}</td>
            <td>{$row['type']}</td>
            <td>{$row['about']}</td>
            <td>{$row['maker']}</td>
            <td>{$row['cost']}</td>
            <td>{$row['selling_price']}</td>
            <td>{$row['img']}</td>
        </tr>
        HTML;
    }
    $table = renderTable(ITEM_TABLE_HEADER_CREATE, $tbody);

    $form = <<< HTML
    <form action="" method="POST">
        <input type="hidden" name="id" value="$id">
        <input type="submit" value="削除" />
    </form>
    HTML;

    $render->body = $title . $table . $form;
    $render->renderHTML();

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = <<< EOT
    DELETE FROM
        items
    WHERE
        items.id = {$_POST['id']}
    EOT;

    $result = $db->query($sql);

    // HTML出力
    $render = new Render();
    $render->title = '在庫管理 - 削除完了';

    $body = <<< HTML
    <h1>削除完了</h1>
    <p>削除が完了しました。</p>
    <form action="/admin/item/list.php" method="GET">
        <input type="submit" value="一覧に戻る" />
    </form>
    HTML;

    $render->body = $body;
    $render->renderHTML();
}

?>