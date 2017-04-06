<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script>
function check_text() {
  
  if($('#kai_1').prop('checked')) {
    $('#alert_text').html('ok');
  } else {
    $('#alert_text').html('no');
  }
  
  var oo = document.getElementById("kai_2");
	  if (document.getElementById("kai_2").checked) {
		  $('#alert_text_2').html('ok');
	  } else {
	      $('#alert_text_2').html('no');
	  }
		  
   if($('#kai_3').prop('checked')) {
    $('#alert_text_3').html('ok');
  } else {
    $('#alert_text_3').html('no');
  }	  
  
}

function check_form() {
   var val_5 = $('#text_val').val();
   var val_6 = val_5.split("");
   if(val_6[0]=='w' || val_6[0]=='h') { //第一個字判斷
     if(val_6[0]=='w') {
	 
	 }
   }
   
   return false;
}

function select_radio(id) {
   var rad_id = $('input[name='+id+']:checked').val();
   
   $('#radio_text').html(rad_id);
}


</script>
</head>

<body>

用jquery的prop function：
<input type="checkbox" id="kai_1" value="kai_1" onClick="check_text()">
<span id="alert_text"></span>
<br><br>
用javascript：
<input type="checkbox" id="kai_2" value="kai_2" onClick="check_text()">
<span id="alert_text_2"></span>

<br><br>
用jquery的attr function:
<input type="checkbox" id="kai_3" value="kai_3" onClick="check_text()">
<span id="alert_text_3"></span>

<form method="post" action="#" onSubmit="return check_form();">
<input type="text" id="text_val" size = "30" name="text_val">
<input type="submit" value="送出">
</form>

RADIO 點選測試：

<input type="radio" id="radio_1" name="radio_1" value="1" onClick="select_radio('radio_1')">開
<input type="radio" id="radio_1" name="radio_1" value="0" onClick="select_radio('radio_1')">關

輸出：<span id="radio_text"></span>
<br><br>
判斷點選checkbox: 
<input type="checkbox" name="kai_4" value="kai_4_a" >
<input type="checkbox" name="kai_4" value="kai_4_b" >
<input type="button" value="click" onClick="all_check()">
<br>
輸出：<span id="all_check_4"></span>
<script>
function all_check() {
   var a='';
   var num=0;
   $("input[type='checkbox']").each(function() {
	     if($(this).prop("checked")==true) {
	       a+= $(this).val()+',';
		   num++;		   
		 }
   });
   
   $('#all_check_4').html(a+'<br>num='+num);
}
</script>

<br><br>
天氣測試：
<br><br>
<?php
/*

Example: Yahoo! Weather API Example Using SimpleXML in PHP.

The base URL for the Weather RSS feed is
http://weather.yahooapis.com/forecastrss

Parameters
w WOEID 
e.g: w=111111

u Units for temperature
f: Fahrenheit
c: Celsius 
e.g.: u=c

*/
/********************/


$wtocn=array(
'AM Clouds / PM Sun'=>'上午有云/下午后晴 ',
'AM Showers'=>'上午阵雨 ',
'AM Snow Showers'=>'上午阵雪 ',
'AM Thunderstorms'=>'上午雷暴雨 ',
'Clear'=>'晴朗 ',
'Cloudy'=>'多云 ',
'Cloudy / Wind'=>'阴时有风 ',
'Clouds Early / Clearing Late'=>'早多云/晚转晴 ',
'Drifting Snow'=>'飘雪 ',
'Drizzle'=>'毛毛雨 ',
'Dust'=>'灰尘 ',
'Fair'=>'晴 ',
'Few Showers'=>'短暂阵雨 ',
'Few Snow Showers'=>'短暂阵雪 ',
'Few Snow Showers / Wind'=>'短暂阵雪时有风 ',
'Fog'=>'雾 ',
'Haze'=>'薄雾 ',
'Hail'=>'冰雹 ',
'Heavy Rain'=>'大雨 ',
'Heavy Rain Icy'=>'大冰雨 ',
'Heavy Snow'=>'大雪 ',
'Heavy Thunderstorms'=>'强烈雷雨 ',
'Isolated Thunderstorms'=>'局部雷雨 ',
'Light Drizzle'=>'微雨 ',
'Light Rain'=>'小雨 ',
'Light Rain Shower'=>'小阵雨 ',
'Light Rain Shower and Windy'=>'小阵雨带风 ',
'Light Rain with Thunder'=>'小雨有雷声 ',
'Light Snow'=>'小雪 ',
'Light Snow Fall'=>'小降雪 ',
'Light Snow Grains'=>'小粒雪 ',
'Light Snow Shower'=>'小阵雪 ',
'Lightening'=>'雷电 ',
'Mist'=>'薄雾 ',
'Mostly Clear'=>'大部晴朗 ',
'Mostly Cloudy'=>'大部多云 ',
'Mostly Cloudy/ Windy'=>'多云时阴有风 ',
'Mostly Sunny'=>'晴时多云 ',
'Partly Cloudy'=>'局部多云 ',
'Partly Cloudy/ Windy'=>'多云时有风 ',
'PM Rain / Wind'=>'下午小雨时有风 ',
'PM Light Rain'=>'下午小雨 ',
'PM Showers'=>'下午阵雨 ',
'PM Snow Showers'=>'下午阵雪 ',
'PM Thunderstorms'=>'下午雷雨 ',
'Rain'=>'雨 ',
'Rain Shower'=>'阵雨 ',
'Rain Shower/ Windy'=>'阵雨/有风 ',
'Rain / Snow Showers'=>'雨或阵雪 ',
'Rain / Snow Showers Early'=>'下雨/早间阵雪 ',
'Rain / Wind'=>'雨时有风 ',
'Rain and Snow'=>'雨夹雪 ',
'Scattered Showers'=>'零星阵雨 ',
'Scattered Showers / Wind'=>'零星阵雨时有风 ',
'Scattered Snow Showers'=>'零星阵雪 ',
'Scattered Snow Showers / Wind'=>'零星阵雪时有风 ',
'Scattered Strong Storms'=>'零星强烈暴风雨 ',
'Scattered Thunderstorms'=>'零星雷雨 ',
'Showers'=>'阵雨 ',
'Showers Early'=>'早有阵雨 ',
'Showers Late'=>'晚有阵雨 ',
'Showers / Wind'=>'阵雨时有风 ',
'Showers in the Vicinity'=>'周围有阵雨 ',
'Smoke'=>'烟雾 ',
'Snow'=>'雪 ',
'Snow / Rain Icy Mix'=>'冰雨夹雪 ',
'Snow and Fog'=>'雾夹雪 ',
'Snow Shower'=>'阵雪 ',
'Snowflakes'=>'雪花 ',
'Sunny'=>'晴朗 ',
'Sunny / Wind'=>'晴时有风 ',
'Sunny Day'=>'晴天 ',
'Thunder'=>'雷鸣 ',
'Thunder in the Vicinity'=>'周围有雷雨 ',
'Thunderstorms'=>'雷雨 ',
'Thunderstorms Early'=>'早有持续雷雨 ',
'Thunderstorms Late'=>'晚有持续雷雨 ',
'Windy'=>'有风 ',
'Windy / Snowy'=>'有风/有雪 ',
'Windy Rain'=>'刮风下雨 ',
'Wintry Mix'=>'雨雪混合'
);

/********************/

$city="tainan"; //設定地區代碼

$result1 = file_get_contents("http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20geo.places%20where%20text%3D%22$city%22&format=xml");
$xml1 = simplexml_load_string($result1);
 $woeid=$xml1->results->place->woeid;

if($woeid!="")
{
$fetchData = file_get_contents("http://weather.yahooapis.com/forecastrss?w=$woeid&u=c");
$xmlData = simplexml_load_string($fetchData);
$location = $xmlData->channel->xpath('yweather:location');

echo "http://weather.yahooapis.com/forecastrss?w=$woeid&u=c"."<br>";
if(!empty($location))
{

foreach($xmlData->channel->item as $data)
{
$current_condition = $data->xpath('yweather:condition');
$forecast = $data->xpath('yweather:forecast');
$current_condition = $current_condition[0];

echo "地區：".$location[0]['city'];
echo "<br>星期：".$forecast[0]['day'];
echo "<br>溫度：".$current_condition['temp'];
$wea=(string)$current_condition['text'];

echo "<br>狀態：".$wea."===".$wtocn[$wea];
echo "<br><img src=\"http://l.yimg.com/a/i/us/we/52/{$current_condition['code']}.gif\" style=\"vertical-align: middle;\"/>";
/*
echo "
<table width=40% border=1 align=center>
<tr>
<td align=center style='background-color:yellow'>
  <h1>{$location[0]['city']}, {$location[0]['region']}</h1>
<small>Date: {$current_condition['date']}</small>
<h2>Current Temprature</h2>
<p>
<span style=\"font-size:64px;font-color:red; font-weight:bold;\">{$current_condition['temp']}°C</span>
<br/>
<img src=\"http://l.yimg.com/a/i/us/we/52/{$current_condition['code']}.gif\" style=\"vertical-align: middle;\"/>
{$current_condition['text']}
</p>
<h2>Forecast</h2>
<b>{$forecast[0]['day']}</b> : {$forecast[0]['text']}. <b>High:</b> {$forecast[0]['high']} <b>Low:</b> {$forecast[0]['low']}
<br/>
<b>{$forecast[1]['day']}</b> - {$forecast[1]['text']}. <b>High:</b> {$forecast[1]['high']} <b>Low:</b> {$forecast[1]['low']}
</p>
</td>
</tr></table>
";
*/

}

}
else
{
echo "<h1>please try a different City.</h1>";
}


}
else
{
echo "<h1>Please try a different City.</h1>";
}

?>
<hr>
判斷輸入文字大小：
<script>
function check_size() {
  var n = $('#name').val(); //抓取內容 
  var num=$('#name').val().length; //抓取數量
  /*
  if(n.match(/^[0-9]*$/)) {
    match(/^[a-zA-Z]*$/)
  }
  */
  $('#7_p').html(num);
  
  if(num<6) {
    alert("您輸入的密碼太少，請至少有6個字以上");
  }
  if(num>12) {
    alert("您輸入的密碼太多，請保持在12個字以內");
  }
  
}
</script>
<input type="text" name="name" id="name">
<input type="button" value="按下判斷" onClick="check_size()">
<br>
文字數量：<text id="7_p">0</text>

<br>
<br>
<br>
<br>



<!--banner 套件測試-->
<!--banner_start-->
<!--需使用http://code.jquery.com/jquery-latest.min.js-->
<link media="screen" rel="stylesheet" type="text/css" href="http://www.futurelove.com.tw/css/banner_slider.css" />
<script type="text/javascript" src="http://www.futurelove.com.tw/js/banner_slider.js"></script>
<!--banner_end-->

<div id="abgneBlock" class="banner" style="width:940px; height:300px;">
  <ul class="list">
    <li><a target="_blank" href="http://www.futurelove.com.tw/online.php"><img src="http://www.futurelove.com.tw/images/banner/banner.jpg" alt="1" /></a></li>
    <li><a target="_blank" href="http://www.futurelove.com.tw/match.php"><img src="http://www.futurelove.com.tw/images/banner/banner2.jpg" alt="2" /></a></li>
    <li><a target="_blank" href="http://www.futurelove.com.tw/activity.php"><img src="http://www.futurelove.com.tw/images/banner/banner3.jpg" alt="3" /></a></li>
    <li><a target="_blank" href="http://www.futurelove.com.tw/compare.php"><img src="http://www.futurelove.com.tw/images/banner/banner4.jpg" alt="4" /></a></li>
    <li><a target="_blank" href="http://www.futurelove.com.tw"><img src="http://www.futurelove.com.tw/images/banner/banner5.jpg" alt="5" /></a></li>
  </ul>
</div>
<hr>
<!--banner 套件測試-->
<div style="margin-top:50px;height:100px;">
  Radio控制table切換: 
  <input type="radio" id="SwitchTable" name="SwitchTable" value="1" onClick="switch_table()">table1
  <input type="radio" id="SwitchTable" name="SwitchTable" value="2" onClick="switch_table()">table2

  <table id="RadioTable_1" style="display:none">
    <tr>
      <td>這是第一張table表</td>
    </tr>
  </table>

  <table id="RadioTable_2" style="display:none">
    <tr>
      <td>這是第二張table表</td>
    </tr>
  </table>
  <script>

  function switch_table(id) {
     var rad_id = $('input[name=SwitchTable]:checked').val(); 
     var len=$("input[name=SwitchTable]").length; //找出radio數量
     
     for(var i=0;i<=len;i++) {
        if(i==rad_id) {
          $('#RadioTable_'+i).css("display","block");
        } else {
          $('#RadioTable_'+i).css("display","none");
        }
     }
  }
  </script>
</div>
<div style="margin-top:50px;">
  google行事曆嵌入測試
  <iframe src="https://www.google.com/calendar/embed?src=q6e1ldv5glsscl5sscqko4jkd0%40group.calendar.google.com&ctz=Asia/Taipei" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
</div>
</body>


</html>