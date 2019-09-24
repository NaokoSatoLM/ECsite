<!DOCTYPE html>
<html lang= "ja">
	<head>
		<meta charaset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0"　//解像度の設定> 　
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<linK rel="stylesheet" href="stylesheet-list.css" type="text/css"></link>
		<meta name="keywords" content=""　//SEO対策用> 
		<meta name="description" content=""　//SEO対策　検索結果一覧に出てくる> 
		<title>商品一覧</title>　
	</head>


<body>
    <h1>PLESER JAPAN</h1>

    <nav>
        <ul calss=navigator>
            <li><a href="index.html">ホーム</a></li>
            <li><a href="list(php.ver).php" >商品一覧</a></li>
            <li><a href='about'>ショップについて</a></li>
            <li><a href='contact'>お問い合わせ</a></li>
        </ul>
	</nav>
	

	<div class="img">
        <ul class="item-contents">
                <?php
                    //データベースに接続
                    $db = new mysqli('mysql','root','root','shoes_db');
                    if ($db->connect_error){
                        echo $db->connect_error;
                        exit();
                    }else{
                        $db->set_charset("utf8");
                    }
                    //３×３の表を作る
                    echo "<table>";
                    //SQL文でデータを取得
                        $sql = "SELECT img,maker, number, about,selling_price,id FROM items";
                        if ($result = $db->query($sql)){
                            //連想配列を取得

                            while ($row = $result->fetch_assoc()){
                                if ($row['id'] == 1 || $row['id'] == 4 || $row['id'] == 7 ) {
                                    echo '<div>';
                                    }
                                echo '<li class="item">' ;
                                echo '<img src="',$row['img'],'"class="heel">';
                                echo "<p> $row[maker],$row[number],$row[about]</p>";
                                echo'<p>¥',number_format($row['selling_price']),'-</p>';
                                echo '</li>';

                                if ($row['id'] == 3 || $row['id'] == 6 || $row['id'] == 9 ) {
                                	echo '</div>';
                                    }
                                }
                            //結果を閉じる
                            $result->close();
                             
                        }
                        echo "</table>";

                    //データベース切断
                    $db->close();
                ?>
        </ul>
    </div>

    

		<!-- // ３×３で商品を表示するため連想配列をきめる
		// $items = [
        //             ['heel' => "商品写真/heel1.jpg" , 'intro' => 'Pleaser(プリーザー) XTREME-809 約20cmハイヒール 超厚底サンダル アンクルストラップ エナメル黒', 'price' =>'¥9,280-'],
        //             ['heel' => "商品写真/heel2.jpg", 'intro' => "Pleaser(プリーザー) BEYOND-097 超厚底サンダル 約25ｃｍヒール 10inch Heel, 6 1/4 PF Criss Cross Ankle Strap Sandal", 'price' =>'¥15,700-'],
        //             ['heel' => "商品写真/long-boots1.jpg", 'intro' => "Pleaser BEYOND-3028 超厚底サイハイブーツ 10インチ／25cmヒール ブラック プリーザー", 'price' =>'¥19,700-'],
        //             ['heel' => "商品写真/heel4.jpg", 'intro' => "Pleaser(プリーザー) XTREME-809 約20cmハイヒール 超厚底サンダル アンクルストラップ エナメル黒", 'price' =>'¥9,280-'],
        //             ['heel' => "商品写真/heel5.jpg", 'intro' => "Pleaser(プリーザー) XTREME-809 約20cmハイヒール 超厚底サンダル アンクルストラップ エナメル黒", 'price' =>'¥9,280-'],
        //             ['heel' => "商品写真/heel6.jpg", 'intro' => "Pleaser(プリーザー) XTREME-809 約20cmハイヒール 超厚底サンダル アンクルストラップ エナメル黒", 'price' =>'¥9,280-'],
        //             ['heel' => "商品写真/heel7.jpg", 'intro' => "Pleaser(プリーザー) XTREME-809 約20cmハイヒール 超厚底サンダル アンクルストラップ エナメル黒", 'price' =>'¥9,280-'],
        //             ['heel' => "商品写真/heel8.jpg", 'intro' => "Pleaser(プリーザー) XTREME-809 約20cmハイヒール 超厚底サンダル アンクルストラップ エナメル黒", 'price' =>'<p>¥9,280-'],
        //             ['heel' => "商品写真/heel9.jpg", 'intro' => "Pleaser(プリーザー) XTREME-809 約20cmハイヒール 超厚底サンダル アンクルストラップ エナメル黒", 'price' =>'¥9,280-']
		// ]; -->




	<!-- <div class="img">
		<ul class="item-contents">
			<!-- ここから繰り返し処理 -->

			<?php
				// foreach ($items as $key => $elements) {

				// 	if ($key == 0 || $key == 3 || $key == 6 ) {
				// 		echo '<div>';
				// 		}

				// 		echo '<li class="item">' ;
				// 		echo '<img src="',$elements['heel'],'" class="heel">';
				// 		echo "<p> {$elements['intro']} </p>";
				// 		echo "<p> {$elements['price']} </p>";
				// 		echo '</li>';


				// 	if ($key == 2 || $key == 5 || $key == 8 ) {
				// 			echo '</div>';
				// 		}
				// 	}
			?>
		<!-- </ul>
	</div>  -->
</body>


</html>