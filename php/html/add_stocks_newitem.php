<?php
    include 'database.php';
    include 'template.php';

    $db = dbconnect();
    html_header('Pleaser 新規追加画面');

    //最初にパラメーターを分ける
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //POSTパラメータを受け取りクエリ発行
        $sql = "INSERT INTO items values('$row[number]','$row[stock]','$row[product_status]','$row[color]','$row[size]')";
    }else{
        //それ以外の場合一覧表示をだす
        $sql = "select * from items" ;
    }


?>

<html>
<body>
    <h1>Pleaser 在庫新規追加画面</h1>


    <?php
    if($_SERVER["REQUEST_METHOD"] != "POST"){
            //POSTできていない場合の処理・・・選択、入力してもらう
            //テーブルitemsのプルダウンを表示

            echo '<table border="1" frame="border" style="table-layout:fixed">';
                echo   '<tr>';
                echo        '<th width=3%>選択してください</th>';
                echo        '<th width=10%>stock</th>';
                echo        '<th width=10%>product_status</th>';
                echo        '<th width=20%>color</th>';
                echo        '<th width=5%>size</th>';
                echo '<tr>';
                //入力部分開始
                echo '<td with=55%>';
                    //プルダウン部分
                    if ($result = $db->query($sql)){
                        echo '<form method="POST" action="">';
                        echo '<select name="info">';
                            foreach($result as $result_val){
                                $number = $result_val['number'];
                            echo '<option value="',$number,'">',
                                $result_val['number'],
                                $result_val['type'],
                                $result_val['about'],
                                
                            '</option>';}
                        echo '</select>';
                        
                        }//プルダウン終わり
                echo'</td>';
                echo '<td><select name ="stock">
                　　　　<option value="あり">あり</option>
                        <option value="なし">なし</option>
                        </select>
                    </td>';
                echo '<td><input type ="text" name ="product_status"></td>';
                echo '<td><input type ="text" name ="color"></td>';
                echo '<td><select name="size">
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        </select>
                </td>';
                echo '</tr>';
                echo '</table>';
                echo '<input type="hidden" name="id" value="',$id,'">
                                <input type="submit" value="確定">';
                echo '</form>'; 

    }else{
    //POSTで送信された情報を受け取りクエリ発行してデータベースにインサートする
    $target_info = $_POST['info']; //選択された型番が出てくる
    $target_stock = $_POST['stock'];
    $target_product_status = $_POST['product_status'];
    $target_color = $_POST['color'];
    $target_size = $_POST['size'];

    echo  'number:',$target_info,'<br>';
    echo  'stock:',$target_stock,'<br>';
    echo  'product_status:',$target_product_status,'<br>';
    echo  'color:',$target_color,'<br>';
    echo  'size:',$target_size,'<br>';       
         
         //新規追加のSQL(インサート)設定・実行
         $sql = "INSERT INTO stocks (number,stock,product_status,color,size) values ('$target_info','$target_stock','$target_product_status','$target_color','$target_size')";

         $result = $db->query($sql);

         echo '登録が完了しました<br>';
         echo '<input type="button" onClick="location.href=\'http://192.168.24.50:8282/admin.stocks.php\'"     value="一覧に戻る">';



        

     
    }
    



    ?>

</body>

</html>
