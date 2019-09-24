<?php
include '/var/www/html/utils/common.php';
include '/var/www/html/utils/database.php';
include '/var/www/html/utils/render.php';
include '/var/www/html/utils/define.php';

$db = dbconnect();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // itemsテーブルから、選択肢を取得
    $sql = <<< EOT
    SELECT
        items.number,
        items.type,
        items.about,
        items.maker
    FROM
        items
    ORDER BY
        items.number
    EOT;
    $result = $db->query($sql);

    while ($row = $result->fetch_assoc()) {
        $options .= <<< HTML
        <option value="{$row['number']}">
            {$row['number']}, {$row['type']}, {$row['about']}, {$row['maker']}
        </option>
        HTML;
    }
    
    // HTML出力
    $render = new Render();
    $render->title = '在庫管理 - 新規登録';
    $title = '<h1>PLEASER JAPAN 登録画面</h1>';

    // テーブル
    $tbody = <<< HTML
    <tr>
        <td>
            <select name="number">
                $options
            </select>
        </td>
        <td>
            <input type="text" name="stock" />
        </td>
        <td>
            <input type="text" name="product_status" />
        </td>
        <td>
            <input type="text" name="color" />
        </td>
        <td>
            <input type="text" name="size" />
        </td>
    </tr>
    HTML;

    $table = renderTable(STOCK_TABLE_HEADER_CREATE, $tbody);
    $form = <<< HTML
    <form action="" method="POST">
        $table
        <input type="submit" value="登録">
    </form>
    HTML;

    $render->body = $title . $form;

    $render->renderHTML();

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = <<< EOT
        INSERT INTO
            stocks
        (
            number,
            stock,
            product_status,
            color,
            size
        )
        VALUES
        (
            '{$_POST['number']}',
            '{$_POST['stock']}',
            '{$_POST['product_status']}',
            '{$_POST['color']}',
            '{$_POST['size']}'
        )
    EOT;
    echo $sql;
    $result = $db->query($sql);

    // HTML出力
    $render = new Render();
    $render->title = '在庫管理 - 登録完了';

    $body = <<< HTML
    <h1>登録完了</h1>
    <p>登録が完了しました。</p>
    <form action="/admin/stock/list.php" method="GET">
        <input type="submit" value="一覧に戻る" />
    </form>
    HTML;

    $render->body = $body;
    $render->renderHTML();
}
?>
