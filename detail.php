<html>
<head>
<meta charset="utf-8">
<title>店舗詳細ページ</title>
<meta name=”robots” content=”noindex” />
<LINK rel="stylesheet" type="text/css" href="restaurant.css">
<br/>
<br/>
<center>
    <h1 class="title"><a href="./">レストラン検索</a></h1>
</center>
<br/>
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
    <div class="content">
    <?php if(isset($info)): ?>
        <?php if(checkString($info->{'name'})): ?>
            <h2><div class="rest-info_title"><?= $info->{'name'} ?></div></h2>
        <?php endif; ?>
        <?php if(checkString($info->{'image_url'}->{'shop_image1'})): ?>
            <div class="rest-info_image">
                <img src="<?= $info->{'image_url'}->{'shop_image1'} ?>">
                <?php if(checkString($info->{'image_url'}->{'shop_image2'})): ?>
                    <img src="<?= $info->{'image_url'}->{'shop_image2'} ?>">
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <br/>
        <?php if(checkString($info->{'budget'})): ?>
            <h3>平均予算</h3>
            <div class="rest-info_pr"><?= $info->{'budget'} ?>円</div><br/>
        <?php endif; ?>
        <?php if(checkString($info->{'address'})): ?>
            <h3>住所</h3>
            <div class="rest-info_address"><?= $info->{'address'} ?></div><br/>
        <?php endif; ?>
        <?php if(checkString($info->{'tel'})): ?>
            <h3>電話番号</h3>
            <div class="rest-info_tel"><?= $info->{'tel'} ?></div><br/>
        <?php endif; ?>
        <?php if(checkString($info->{'opentime'})): ?>
            <h3>営業時間</h3>
            <div class="rest-info_tel"><?= $info->{'opentime'} ?></div><br/>
        <?php endif; ?>
        <?php if(checkString($info->{'holiday'})): ?>
            <h3>休業日</h3>
            <div class="rest-info_tel"><?= $info->{'holiday'} ?></div><br/>
        <?php endif; ?>
    <?php endif; ?>
    <br/>
    <br/>
    </div>
</body>
</html>
