<html>
<head>
<meta charset="utf-8">
<title>結果一覧ページ</title>
<meta name=”robots” content=”noindex” />
<br/>
<br/>
<br/>
<br/>
<div class="title">
    <center>
        <a href="./"><h1>レストラン検索</h1></a>
    </center>
</div>
</head>

<?php
    $uri = "http://api.gnavi.co.jp/RestSearchAPI/20150630/";
    $acckey= "6311242a5d72d4380ed5add96f0b3d4d";
    $format = "json";  //返却時のフォーマット
    $hit_per_page = 15; //1ページの表示数

    if(isset($_GET['range'])){
        $range = $_GET['range'];   //範囲
    }else{
        $range = 1;
    }

    if(isset($_GET['location'])){
        $location = $_GET['location'];
        switch($location){
            case 1: //現在位置
                $lat = $_GET['lat'];  //緯度
                $lon = $_GET['lon'];  //経度
                break;
            case 2:  //梅田駅
                $lat = 34.705027;  //緯度
                $lon = 135.498427;  //経度
                break;
            case 3:  //日比谷シャンテ
                $lat = 35.670083;  //緯度
                $lon = 139.763267;  //経度
                break;
        }
    }else{
        $lat = "";
        $lon = "";
    }

    if(isset($_GET['page'])){
        $page_num = $_GET['page'];   //検索開始ページ
    }else{
        $page_num = 1;   //検索開始ページ
    }

    $url = sprintf("%s%s%s%s%s%s%s%s%s%s%s%s%s%s%s", $uri, "?format=", $format, "&keyid=", $acckey, "&latitude=", $lat,"&longitude=",$lon,"&range=",$range,"&offset_page=",$page_num,"&hit_per_page=",$hit_per_page);

    $json = file_get_contents($url);  //API実行
    $obj  = json_decode($json);   //取得した結果をオブジェクト化

    $page_url = str_replace('&page='.$page_num,'',$_SERVER["REQUEST_URI"]);  //現在のurl
?>

<body>
    <?php foreach((array)$obj as $key => $val): ?>
        <?php
            if(strcmp($key, "total_hit_count" ) == 0 ){
                echo "全".$val."件";
                echo "<br/><br/>";

                $total_page = floor($val / $hit_per_page) + 1; //全ページ数
            }
        ?>
        <?php if(strcmp($key, "rest") == 0): ?>
            <?php foreach((array)$val as $restArray): ?>
                <div class="rest">
                    <?php if(checkString($restArray->{'name'})): ?>
                        <div class="rest_title">
                            <a href="./detail.php?id=<?= $restArray->{'id'} ?>" target="_blank">
                                <?= $restArray->{'name'} ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if(checkString($restArray->{'access'}->{'line'}) && checkString($restArray->{'access'}->{'station'}) && checkString($restArray->{'access'}->{'station_exit'}) && checkString($restArray->{'access'}->{'walk'})): ?>
                        <div class="rest_access">
                                <?= $restArray->{'access'}->{'line'} ?>
                                <?= $restArray->{'access'}->{'station'} ?>
                                <?= $restArray->{'access'}->{'station_exit'} ?>
                                <?= $restArray->{'access'}->{'walk'} ?>分
                        </div>
                    <?php endif; ?>
                    <?php if(checkString($restArray->{'image_url'}->{'shop_image1'})): ?>
                        <div class="rest_image1">
                            <img src="<?= $restArray->{'image_url'}->{'shop_image1'} ?>">
                        </div>
                    <?php endif; ?>
                </div><br/>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <br/>
    <br/>
    <?php
        $start_num = $page_num - 4;   //現在のページの前後4ページのリンク表示
        if($start_num < 1){
            $start_num = 1;
        }
    ?>
    <a href="<?= $page_url ?>&page=1">最初</a>|<br/>
    <?php if($page_num > 1): ?>
        <a href="<?= $page_url ?>&page=<?php echo ($page_num - 1); ?>"><<前</a><br/>
    <?php endif; ?>

    <?php for($i=$start_num; $i<=$start_num+8; $i++): ?>
        <?php if($i <= $total_page): ?>
            <?php if($i != $page_num): ?>
                <a href="<?= $page_url ?>&page=<?php echo ($i); ?>"><?= $i ?></a><br/>
            <?php else: ?>
                <b><?= $i ?><br/></b>
            <?php endif; ?>
        <?php else: ?>
            <?php break; ?>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if($page_num < $total_page): ?>
        <a href="<?= $page_url ?>&page=<?php echo ($page_num + 1); ?>">次>></a><br/>
    <?php endif; ?>
    |<a href="<?= $page_url ?>&page=<?= $total_page ?>">最後</a><br/>
</body>
</html>



<?php
    function checkString($input)     //文字列であるかをチェック
    {
        if(isset($input) && is_string($input)) {
            return true;
        }else{
            return false;
        }
    }
?>
