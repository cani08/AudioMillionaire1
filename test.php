<?php
/*$numbersarray= array();
for($i=0;$i<=9;$i++){
    $number=rand(1,30);
    if(in_array($number,$numbersarray)){
        $i--;
    }else{
        $numbersarray[$i]=$number;
    }
}
for($i=0;$i<=9;$i++){
    echo $numbersarray[$i]." , ";
}*/
?>
<html>
<head>
    <script src="jquery.js"></script>  
    </head>
    <body>
    <div id="left" style="float:left; border:1px solid black; width:100px; height:100px;">
        <div id="asdassssd">
        <table></table></div>
        </div>
    <div id="right" style="float:right; border:1px solid black;width:100px; height:100px;">
        <div id="asdasd">
        <table></table>
        </div>
        </div>
        <button id="bleft">left</button>
        <button id="bright">right</button>
    <script>
         $('#bleft').click(function() {
          $('#left').show(500);
          $('#right').hide(500);
           });
         $('#bright').click(function() {
          $('#left').hide(500);
          $('#right').show(500);
           });
        
        
        </script>
    </body>
</html>

