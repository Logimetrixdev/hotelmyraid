<html>
<head>
<script>
var chkArray = [];

function addCheckBox() {
  var chk1 = document.getElementById('1').checked;
  var chk2 = document.getElementById('2').checked;
  var chk3 = document.getElementById('3').checked;
  var chk4 = document.getElementById('4').checked;

  if(chk1 == true && chkArray.indexOf(1) == -1) {  
    chkArray.push(1);
    alert('Added 1');
  }else if(chk2 == true && chkArray.indexOf(2) == -1) {
    chkArray.push(2);
    alert('Added 2');  
  }else if(chk3 == true && chkArray.indexOf(3) == -1) { 
    chkArray.push(3);
    alert('Added 3');
  }else if(chk4 == true && chkArray.indexOf(4) == -1) { 
    chkArray.push(4);
    alert('Added 4');
  }
}
</script>
</head>
<body onClick="addCheckBox();">
<input type="checkbox" value="2" id="1">
<input type="checkbox" value="3" id="2">
<input type="checkbox" value="4" id="3">
<input type="checkbox" value="5" id="4">
<?php
$number = 15000054;
$format = number_format($number);
echo $format;
?>
</body>
</html>