<html>
<head>
<meta charset="utf-8">
<title>店舗詳細ページ</title>
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
    if(isset($_GET['id'])){
        $uri = "http://api.gnavi.co.jp/RestSearchAPI/20150630/";
        $acckey= "6311242a5d72d4380ed5add96f0b3d4d";
        $format = "json";       //返却時のフォーマット

        $id = $_GET['id'];       //店舗id

        $url = sprintf("%s%s%s%s%s%s%s", $uri, "?format=", $format, "&keyid=", $acckey, "&id=", $id);

        $json = file_get_contents($url);  //API実行
        $obj  = json_decode($json);   //取得した結果をオブジェクト化
        $info = $obj->{'rest'};

        function checkString($input)     //文字列であるかをチェック
        {
            if(isset($input) && is_string($input)) {
                return true;
            }else{
                return false;
            }
        }
    }
?>

<body>
    <div class="rest-info">
        <?php if(checkString($info->{'name'})): ?>
            <div class="rest-info_title"><?= $info->{'name'} ?></div>
        <?php endif; ?>
        <?php if(checkString($info->{'address'})): ?>
            <div class="rest-info_address"><?= $info->{'address'} ?></div>
        <?php endif; ?>
        <?php if(checkString($info->{'tel'})): ?>
            <div class="rest-info_tel"><?= $info->{'tel'} ?></div>
        <?php endif; ?>
        <?php if(checkString($info->{'opentime'})): ?>
            <div class="rest-info_tel"><?= $info->{'opentime'} ?></div>
        <?php endif; ?>
        <?php if(checkString($info->{'image_url'}->{'shop_image1'})): ?>
            <div class="rest-info_image1">
                <img src="<?= $info->{'image_url'}->{'shop_image1'} ?>">
            </div>
        <?php endif; ?>
        <?php if(checkString($info->{'image_url'}->{'shop_image2'})): ?>
            <div class="rest-info_image2">
                <img src="<?= $info->{'image_url'}->{'shop_image2'} ?>">
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
