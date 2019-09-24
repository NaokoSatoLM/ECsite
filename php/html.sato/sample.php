<?php
header("Content-Type: text/html; charset=UTF-8");
$db = new PDO("sqlite:sample.db");
$db->exec("CREATE TABLE IF NOT EXISTS sample (id INTEGER PRIMARY KEY, name TEXT, age INTEGER)");

/**************/
/* データ取得 */
/**************/

if (isset($_GET["func"]) && $_GET["func"] == "get_data") {
    $stmt = $db->query("SELECT * FROM sample");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($rows);
    echo $json;
    exit();

//*********************************/*
/* データ更新（削除、変更、追加） 　 */
//*********************************/*

} else if (isset($_POST["func"]) && $_POST["func"] == "upd_data") {
    // データ受取
    $delid = $_POST["delid"];
    $delid = json_decode($delid, true);
    $upddata = $_POST["upddata"];
    $upddata = json_decode($upddata, true);
    $insdata = $_POST["insdata"];
    $insdata = json_decode($insdata, true);

    // トランザクション開始
    $db->beginTransaction();
    // データ削除
    if ($delid) {
        for ($i=0; $i<count($delid); $i++) {
            $sql = "DELETE FROM sample WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($delid[$i]["id"]));
        }
    }
    // データ変更
    if ($upddata) {
        for ($i=0; $i<count($upddata); $i++) {
            $sql = "UPDATE sample SET name=?, age=? WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($upddata[$i]["name"], $upddata[$i]["age"], $upddata[$i]["id"]));
        }
    }
    // データ追加
    if ($insdata) {
        for ($i=0; $i<count($insdata); $i++) {
            $sql = "INSERT INTO sample (name, age) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($insdata[$i]["name"], $insdata[$i]["age"]));
        }
    }
    // トランザクション終了
    $db->commit();
    exit();
}
$db = null;
?>

<html>
<head>
<script type="text/javascript">
var Ajax = new XMLHttpRequest();

// 削除対象IDを格納する配列
var delid = [];

// 変更データを格納する配列
var upddata = [];

// 新規登録データを格納する配列
var insdata = [];

window.onload = getSample;

/************/
/* 一覧表示 */
/************/

function getSample() {
    var rows, row, i, out;
    var url = "sample.php" + "?dummy=" + new Date().getTime() + "&func=" + "get_data";
    Ajax.open("GET", url, true);
    Ajax.send(null);
    Ajax.onreadystatechange = function() {
        if (Ajax.readyState == 4 && Ajax.status == 200) {
            out = '<table border="1" id="sampletb">';
            out += '<tr>';
            out += '<th>削除</th>';
            out += '<th>ID</th>';
            out += '<th>氏名</th>';
            out += '<th>年齢</th>';
            out += '</tr>';
            var res = Ajax.responseText;
            if (res) {
                rows = JSON.parse(res);
                for (i in rows) {
                    out += '<tr>';
                    out += '<td><input type="checkbox" id="'+i+':0" onClick="delCheck(this);"></td>';
                    out += '<td><input type="text" id="'+i+':1" value='+rows[i]["id"]+' disabled></td>';
                    out += '<td><input type="text" id="'+i+':2" value="'+rows[i]["name"]+'" onChange="updCheck(this)";></td>';
                    out += '<td><input type="text" id="'+i+':3" value="'+rows[i]["age"]+'" onChange="updCheck(this)";></td>';
                    out += '</tr>';
                }   
            }
            out += '</table>';
            out += '<p>';
            out += '<button type="button" onClick="addRow();">'+"行追加"+'</button>';
            out += '<button type="button" onClick="Upd();">'+"更新"+'</button>';
            out += '</p>';
            document.getElementById("result").innerHTML = out;
        }
    }
}

/**********/
/* 行追加 */
/**********/

function addRow() {
    var el = document.getElementById('sampletb');
    var i = el.rows.length;
    var insertRow = el.insertRow(i);
    var insertCell0 = insertRow.insertCell(0);
    var insertCell1 = insertRow.insertCell(1);
    var insertCell2 = insertRow.insertCell(2);
    var insertCell3 = insertRow.insertCell(3);
    insertRow.style.backgroundColor = 'blue';
    // 1:insid, 2:name, 3:age
    insertCell0.innerHTML = '<td><input type="checkbox"></td>';
    insertCell1.innerHTML = '<input type="text" id="'+i+':1" value="'+i+'" style="width:20px;">';
    insertCell2.innerHTML = '<input type="text" id="'+i+':2" value="" onChange="insCheck(this)";>';
    insertCell3.innerHTML = '<input type="text" id="'+i+':3" value="" onChange="insCheck(this)";>';
}

/************/
/* 新規登録 */
/************/

function insCheck(e) {
    var index = e.id.indexOf(":");
    var row = e.id.substring(0, index);
    var insid = document.getElementById(row+':1').value;
    var name = document.getElementById(row+':2').value;
    var age = document.getElementById(row+':3').value;
    // 最初の登録処理
    if (insdata.length == 0) {
        insdata.push({"insid":insid, "name":name, "age":age});
        return;
    }
    // 2件目以降の登録処理
    // 重複がある場合の登録処理
    for (var i=0; i<insdata.length; i++) {
        if (insdata[i]["insid"] == insid) {
            // 配列から除外
            insdata.splice(i, 1);
            // 配列に追加
            insdata.push({"insid":insid, "name":name, "age":age});
            return;
        } 
    }
    // 重複がない場合の登録処理
    insdata.push({"insid":insid, "name":name, "age":age});
}

/********/
/* 変更 */
/********/

function updCheck(e) {
    e.parentNode.style.backgroundColor = 'yellow';
    var row = e.id.substr(0, e.id.indexOf(":"));
    var tid = document.getElementById(row+':1').value;
    var name = document.getElementById(row+':2').value;
    var age = document.getElementById(row+':3').value;
    // 最初の変更処理
    if (upddata.length == 0) {
        upddata.push({"id":tid, "name":name, "age":age});
        return;
    }
    // 2件目以降の変更処理
    // 重複がある場合の変更処理
    for (var i=0; i<upddata.length; i++) {
        if (upddata[i]["id"] == tid) {
            // 配列から除外
            upddata.splice(i, 1);
            // 配列に追加
            upddata.push({"id":tid, "name":name, "age":age});
            return;
        }
    }
    // 重複がない場合の変更処理
    upddata.push({"id":tid, "name":name, "age":age});
}

/********/
/* 削除 */
/********/

function delCheck(e) {
    var tid = document.getElementById(e.id.replace(':0',':1')).value;
    // チェック入れたとき
    if (e.checked == true) {
        e.parentNode.parentNode.style.backgroundColor = 'red';
        delid.push({"id":tid});
    // チェック外したとき
    } else if (e.checked == false) {
        e.parentNode.parentNode.style.backgroundColor = '';
        for (var i=0; i<delid.length; i++) {
            if (delid[i]["id"] == tid) {
                delid.splice(i, 1);
            }
        }
    }
}

/************/
/* 更新処理 */
/************/

function Upd() {
    delid2 = JSON.stringify(delid);
    upddata2 = JSON.stringify(upddata);
    insdata2 = JSON.stringify(insdata);
    url = "sample.php";
    Ajax.open("POST", url, true);
    Ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    Ajax.send("func=" + "upd_data" + "&delid=" + delid2 + "&upddata=" + upddata2 + "&insdata=" + insdata2);
    Ajax.onreadystatechange = function() {
        if (Ajax.readyState == 4 && Ajax.status == 200) {
            getSample();
            // 配列初期化
            delid.length=0;
            upddata.length=0;
            insdata.length=0;
        }
    }
}

</script>
</head>
<body>
<div id="result"></div>
</body>
</html>


