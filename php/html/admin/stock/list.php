<?php
include '/var/www/html/utils/common.php';
include '/var/www/html/utils/database.php';
include '/var/www/html/utils/render.php';
include '/var/www/html/utils/define.php';

method_prohibit('POST');

// GETパラメータ取得
$number = $_GET['number'];
$maker = $_GET['maker'];
$type = $_GET['type'];

// db接続して、クエリ発行
$db = dbconnect();
$sql = <<< EOT
    SELECT
        stocks.id,
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
        stocks on items.number=stocks.number
    WHERE
        items.number like '%$number%'
    and items.type like '%$type%'
    and items.maker like '%$maker%'
    ORDER BY
        items.number, stocks.color, stocks.size
EOT;
$result = $db->query($sql);

// ここからHTML出力
$render = new Render();
$render->title = '在庫管理';

// タイトル部分
$title = '<h1>PLEASER 在庫一覧</h1>';

// 検索項目部分
$search = <<< HTML
    <form action="" method="GET">
        <label for="number">Number:</label>
        <input type="text" id="number" name="number" />

        <label for="number">Type:</label>
        <input type="text" id="type" name="type" />

        <label for="maker">Maker:</label>
        <input type="text" id="maker" name="maker" />

        <input type="submit" value="検索" />
    </form>
HTML;

// 新規登録フォームへの遷移
$create = <<< HTML
    <form action="/admin/stock/create.php" method="GET">
        <input type="submit" value="新規登録" />
    </form>
HTML;

// テーブル部分
// ボディー
while ($row = $result->fetch_assoc()) {
    $tbody .= <<< HTML
    <tr>
        <td>
            <form action="/admin/stock/update.php" method="GET">
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
        <td>{$row['stock']}</td>
        <td>{$row['product_status']}</td>
        <td>{$row['color']}</td>
        <td>{$row['size']}</td>
    </tr>
    HTML;
}
$table = renderTable(STOCK_TABLE_HEADER_EDITABLE, $tbody);

$render->body = $title . $search . $create . $table;
$render->renderHTML();
?>
