<?php
  function getImgUrl($number){
    if ($number < 10){
      $number = "0{$number}";
    }
    return "../img/sdg_icon_{$number}_ja_2-290x290.png";
  }
 ?>
