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
    $offset_page = 1;   //検索開始ページ

    if(isset($_POST['range'])){
        $range = $_POST['range'];   //範囲
    }else{
        $range = 1;
    }

    if(isset($_POST['location'])){
        $location = $_POST['location'];
        switch($location){
            case 1: //現在位置
                $lat = $_POST['lat'];  //緯度
                $lon = $_POST['lon'];  //経度
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

    $url = sprintf("%s%s%s%s%s%s%s%s%s%s%s%s%s", $uri, "?format=", $format, "&keyid=", $acckey, "&latitude=", $lat,"&longitude=",$lon,"&range=",$range,"&offset_page=",$offset_page);

    $json = file_get_contents($url);  //API実行
    $obj  = json_decode($json);   //取得した結果をオブジェクト化


    function checkString($input)     //文字列であるかをチェック
    {
        if(isset($input) && is_string($input)) {
            return true;
        }else{
            return false;
        }
    }
?>

<body>
    <?php foreach((array)$obj as $key => $val): ?>
        <?php
            if(strcmp($key, "total_hit_count" ) == 0 ){
                echo "全".$val."件";
                echo "<br/><br/>";
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
</body>
</html>
