<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
  <title>Bootstrap Navigation Bar</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">//匯入bootstrap
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>//匯入jQuery
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>//匯入bootstrap javascript
</head>
<!--header--> 
123
<ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#home">Home</a></li>
        <li><a data-toggle="tab" href="#menu1">Page 1</a></li>
        <li><a data-toggle="tab" href="#menu2">Page 2</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Dropdown<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="#">First</a></li>
                <li><a href="#">Second</a></li>
                <li><a href="#">Third</a></li>
            </ul>
        </li>
    </ul>
        
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <h3>HOME</h3>
            <p>Some content.</p>
        </div>
        <div id="menu1" class="tab-pane fade">
            <h3>Menu 1</h3>
            <p>Some content in menu 1.</p>
        </div>
        <div id="menu2" class="tab-pane fade">
            <h3>Menu 2</h3>
            <p>Some content in menu 2.</p>
        </div>
    </div>
<!---->

<div id="demoContent">
測試前
</div>

<input type="button" onclick="checkTest();" value="按我">

<script>
function checkTest() {
  alert('okokok');
  document.getElementById("demoContent").innerHTML = "okokok";

}

</script>
<!---->
</body>
</html>