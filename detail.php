<html>
<head>
<meta charset="utf-8">
<title>店舗詳細ページ</title>
<meta name=”robots” content=”noindex” />
</head>

<body>
    <br/>
    <br/>
    <br/>
    <br/>
    <div class="title">
        <center>
            <h1>レストラン検索</h1>
        </center>
    </div>

<?php
    $uri = "http://api.gnavi.co.jp/RestSearchAPI/20150630/";
    $acckey= "6311242a5d72d4380ed5add96f0b3d4d";
    $format = "json";       //返却時のフォーマット
    $id = "7603442";       //店舗id

    $url = sprintf("%s%s%s%s%s%s%s", $uri, "?format=", $format, "&keyid=", $acckey, "&id=", $id);

    $json = file_get_contents($url);  //API実行
    $obj  = json_decode($json);   //取得した結果をオブジェクト化

    var_dump($obj);
?>

</body>
</html>
