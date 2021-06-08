<?php
  function getImgUrl($number){
    if ($number < 10){
      $count = "0{$number}";
    }
    return "../img/sdg_icon_{$count}_ja_2-290x290.png";
  }
 ?>
