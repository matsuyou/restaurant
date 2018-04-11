<html>
<head>
<meta charset="utf-8">
<title>検索ページ</title>
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

    <form action="list.php" method="post">
        <center>
            <input type="hidden" name="url" value = "<?php echo $url;?>">
            <input type="submit" value="検索" />
        </center>
    </form>
</body>
</html>


<script>
    // Geolocation API 対応確認
    if (navigator.geolocation) {
      //alert("この端末では位置情報が取得できます");
      // Geolocation APIに対応していない
    } else {
        alert("この端末では位置情報が取得できません");
    }

    getPosition();

    // 現在地取得処理
    function getPosition() {
        navigator.geolocation.getCurrentPosition(   //現在位置を取得

            function(position) { //取得成功した場合
                alert("緯度:"+position.coords.latitude+",経度"+position.coords.longitude);
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
            }
        );
    }
 </script>
