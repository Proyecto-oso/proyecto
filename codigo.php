<?php


  $string = 'el respondio "no quiero ser gay"';
  $replacement = '\\'.'\'';
  echo $string."</br>";
  $string2 = str_replace('"',$replacement, $string);
  echo $string2;
 ?>
