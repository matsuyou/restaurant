<html>
<head>
<meta charset="utf-8">
<title>結果一覧ページ</title>
<meta name=”robots” content=”noindex” />
<LINK rel="stylesheet" type="text/css" href="restaurant.css">
<br/>
<br/>
<center>
    <h1 class="title"><a href="./">レストラン検索</a></h1>
</center>
<br/>
</div>

<?php
    $uri = "http://api.gnavi.co.jp/RestSearchAPI/20150630/";
    $acckey= "6311242a5d72d4380ed5add96f0b3d4d";
    $format = "json";  //返却時のフォーマット
    $hit_per_page = 10; //1ページの表示数

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
    <div class="content">
    <?php if(isset($obj)): ?>
    <?php foreach((array)$obj as $key => $val): ?>
        <?php
            if(strcmp($key, "total_hit_count" ) == 0 ){
                echo "全".$val."件";
                echo "<br/>";

                $total_page = floor(($val-1) / $hit_per_page) + 1; //全ページ数(上限100ページ？)
                if($total_page>100){
                    $total_page = 100;
                }
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
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <br/>

    <div class="pagenation">
    <?php
        $start_num = $page_num - 3;   //現在のページの前後3ページのリンク表示
        if($start_num < 1){
            $start_num = 1;
        }
    ?>
    <ul>
    <li><a href="<?= $page_url ?>&page=1">最初</a></li>
    <?php if($page_num > 1): ?>
        <li><a href="<?= $page_url ?>&page=<?php echo ($page_num - 1); ?>"><<前</a></li>
    <?php endif; ?>

    <?php for($i=$start_num; $i<=$start_num+6; $i++): ?>
        <?php if($i <= $total_page): ?>
            <?php if($i != $page_num): ?>
                <li><a href="<?= $page_url ?>&page=<?php echo ($i); ?>"><?= $i ?></a></li>
            <?php else: ?>
                <li><a class="active" href="<?= $page_url ?>&page=<?php echo ($i); ?>"><?= $i ?></a></li>
            <?php endif; ?>
        <?php else: ?>
            <?php break; ?>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if($page_num < $total_page): ?>
        <li><a href="<?= $page_url ?>&page=<?php echo ($page_num + 1); ?>">次>></a></li>
    <?php endif; ?>
    <li><a href="<?= $page_url ?>&page=<?= $total_page ?>">最後</a></li>
    </ul>
    <?php endif; ?>
    </div>
    <br/>
    <br/>
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
