<?php

function html_header($title) {
     <<<EOT
    <head>
        <meta charset="utf-8">
        <mata name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0"
        <meta http-equiv="content-type" content="text/html";charaser="utf-8">
        <!-- <link rel="stylesheet" href="stylesheet-list.css"
        type="text/css"></link> -->
        <meta name="kyeword" content="">
        <meta name="description" content="">
        <title>$title</title>
    </head>
    EOT;
}

function stock_table($result, $editable) {
    echo<<<HTML
    <table border="1" frame="border" style="table-layout:fixed">
        <tr>
            <th width="2%"></th>
            <th width="10%">number</th>
            <th width="10%">type</th>
            <th width="10%">about</th>
            <th width="5%">maker</th>
            <th width="5%">cost</th>
            <th width="5%">selling_price</th>
            <th width="10%">stock</th>
            <th width="10%">product_status</th>
            <th width="8%">color</th>
            <th width="5%">size</th>
        </tr>
    HTML;

    if($editable){
        while ($row = $result->fetch_assoc()) {
            echo
            <<<HTML
            <tr>
                <td></td>
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
        echo '</table>';
    } else {
        while ($row = $result->fetch_assoc()){
                echo
                <<<HTML
                <tr>
                    <td></td>
                    <td>{$row['number']}</td>
                    <td>{$row['type']}</td>
                    <td>{$row['about']}</td>
                    <td>{$row['maker']}</td>
                    <td>{$row['cost']}</td>
                    <td>{$row['selling_price']}</td>
                    <form action="" method="POST">
                    <td><input 
                                type="text" name="stock" value="{$row['stock']}"></td>
                    <td><input
                                type="text" name="product_status" value="{$row['product_status']}"></td>
                    <td><input 
                                type="text" name="color" value="{$row['color']}"></td>
                    <td><input 
                                type="text" name="size" value="{$row['size']}"></td>
                </tr>
                </table>
                <input type="hidden" name="target_id" value="{$row['id']}">
                <input type="hidden" name="number" value="{$row['number']}">
                <input type="submit"   value="変更を確定する">
                </form>
                <form>
                    <input type="button" onClick="location.href='http://192.168.24.50:8282/admin.stocks.php'"     value="一覧に戻る">
                </form>
            HTML;
                
         }
     }
}
?>
