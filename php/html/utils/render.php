<?php
class Render
{
    // プロパティ
    public $title;
    public $body;

    // メソッド
    public function renderHTML() {
        echo <<< HTML
        <html lang ="ja">
            <head>
                <meta charset="utf-8">
                <mata name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0"
                <meta http-equiv="content-type" content="text/html";charaser="utf-8">
                <!-- <linK rel="stylesheet" href="create_style_sheet.css" type="text/css"></link> -->
                <meta name="kyeword" content="">
                <meta name="description" content="">
                <title>{$this->title}</title>
            </head>
            <body>
                {$this->body}
            </body>
        </html>
        HTML;
    }
}

function renderTable($thead, $tbody) {
    foreach ($thead as $tr) {
        $th .= <<< HTML
            <th width="{$tr['width']}">
                {$tr['label']}
            </th>
        HTML;
    }

    return <<< HTML
    <table border="1" frame="border" style="table-layout:fixed">
        <thead>
            <tr>
                {$th}
            </tr>
        </thead>
        <tbody>
            {$tbody}
        </tbody>
    </table>
    HTML;
}
?>
