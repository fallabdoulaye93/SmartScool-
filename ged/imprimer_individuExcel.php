<?php

//var_dump($_GET);exit;
 $page="liste_tiersExcel.php";
 header("Content-type: application/vnd.ms-excel; charset=UTF-8");

 header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");

 header("Content-Disposition: attachment; filename=listeTierExcel.xls");
  if(file_exists( $page)){
       ob_start();
       include($page);;
       $content = ob_get_clean();
   }else $content = $page;
      echo "\xEF\xBB\xBF"; // UTF-8 BOM
      print $content;
      exit;

?>

