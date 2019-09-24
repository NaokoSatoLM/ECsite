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
            items.selling_price,
            stocks.stock,
            stocks.product_status,
            stocks.color,
            stocks.size
        FROM
            items
        LEFT JOIN
            stocks on items.number = stocks.number
        WHERE
            stocks.id = $id
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
            <td>{$row['type']}</td>
            <td>{$row['about']}</td>
            <td>{$row['maker']}</td>
            <td>{$row['cost']}</td>
            <td>{$row['selling_price']}</td>
            <td>
                <input type="text" name="stock" value="{$row['stock']}" />
            </td>
            <td>
                <input type="text" name="product_status" value="{$row['product_status']}" />
            </td>
            <td>
                <input type="text" name="color" value="{$row['color']}" />
            </td>
            <td>
                <input type="text" name="size" value="{$row['size']}" />
            </td>
        </tr>
        HTML;
    }
    $table = renderTable(STOCK_TABLE_HEADER, $tbody);
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
        stocks
    SET
        stock = '{$_POST['stock']}',
        product_status = '{$_POST['product_status']}',
        color = '{$_POST['color']}',
        size = '{$_POST['size']}'
    WHERE
        stocks.id = {$_POST['id']}
    EOT;

    $result = $db->query($sql);

    // HTML出力
    $render = new Render();
    $render->title = '在庫管理 - 修正完了';

    $body = <<< HTML
    <h1>修正完了</h1>
    <p>修正が完了しました。</p>
    <form action="/admin/stock/list.php" method="GET">
        <input type="submit" value="一覧に戻る" />
    </form>
    HTML;

    $render->body = $body;
    $render->renderHTML();
}

?>
