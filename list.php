<html>
<head>
<meta charset="utf-8">
<title>結果一覧ページ</title>
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
    //if(isset($_POST['url'])){
        $uri = "http://api.gnavi.co.jp/RestSearchAPI/20150630/";
        $acckey= "6311242a5d72d4380ed5add96f0b3d4d";
        $format = "json";  //返却時のフォーマット
        $lat = 35.670083;  //緯度
        $lon = 139.763267;  //経度
        $range = 1;   //範囲300m以内
        $offset_page = 1;   //検索開始ページ

        $url = sprintf("%s%s%s%s%s%s%s%s%s%s%s%s%s", $uri, "?format=", $format, "&keyid=", $acckey, "&latitude=", $lat,"&longitude=",$lon,"&range=",$range,"&offset_page=",$offset_page);

        $json = file_get_contents($url);  //API実行
        $obj  = json_decode($json);   //取得した結果をオブジェクト化

        foreach((array)$obj as $key => $val){
            if(strcmp($key, "total_hit_count" ) == 0 ){
                echo "該当件数: ".$val;
                echo "<br/><br/>";
            }

            if(strcmp($key, "rest") == 0){
                foreach((array)$val as $restArray){
                    if(checkString($restArray->{'id'}))   echo $restArray->{'id'}."\t";
                    if(checkString($restArray->{'name'})) echo $restArray->{'name'}."\t";

                    foreach((array)$restArray->{'code'}->{'category_name_s'} as $v){
                        if(checkString($v)) echo $v."\t";
                    }
                    echo "<br/>";
                }
            }
        }

        function checkString($input)     //文字列であるかをチェック
        {
            if(isset($input) && is_string($input)) {
                return true;
            }else{
                return false;
            }
        }
?>

</body>
</html>
