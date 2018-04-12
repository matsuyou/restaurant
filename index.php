<html>
<head>
<meta charset="utf-8">
<title>検索ページ</title>
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

<body>
    <form action="list.php" method="post" name="rest_form">
        <center>
            検索範囲(半径):
            <select name="range">
                <option value="1">300m</option>
                <option value="2">500m</option>
                <option value="3">1km</option>
                <option value="4">3km</option>
            </select><br/>
            検索場所：
            <select name="location">
                <option value="1">現在位置</option>
                <option value="2">梅田駅</option>
                <option value="3">日比谷シャンテ</option>
            </select><br/>
            <input type="hidden" name="url" value = "<?php echo $url;?>">
            <input id="lat" type="hidden" name="lat" value = "">
            <input id="lon" type="hidden" name="lon" value = "">
            <br/>
            <input type="button" value="検索" onClick="getPosition()" />
        </center>
    </form>
</body>
</html>

<script>
    // Geolocation API 対応確認
    if (navigator.geolocation) {
        //alert("この端末は位置情報が取得できます");
    } else {
        alert("この端末では位置情報が取得できません");
    }

    // 現在地取得処理
    function getPosition() {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(   //現在位置を取得
                function(position) { //取得成功した場合
                    var lat = position.coords.latitude;  //緯度
                    var lon = position.coords.longitude; //経度
                    document.getElementById('lat').value= lat;
                    document.getElementById('lon').value= lon;

                    document.rest_form.submit();
                },
                function(error) {  // 取得失敗した場合
                    switch(error.code) {
                        case 1: //PERMISSION_DENIED
                            alert("位置情報の利用が許可されていません");
                            break;
                        case 2: //POSITION_UNAVAILABLE
                            alert("現在位置が取得できませんでした");
                            break;
                        case 3: //TIMEOUT
                            alert("タイムアウトになりました");
                            break;
                        default:
                            alert("エラーコード:"+error.code);
                            break;
                    }
                    document.rest_form.submit();
                },
                {
	                "timeout": 3000,
                }
            );
        }else{
            alert("この端末では位置情報が取得できません");
            document.rest_form.submit();
        }
    }
</script>
