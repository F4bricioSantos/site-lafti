<?php 
  $server ="Localhost";
  $user = "root";
  $pass = "";
  $bd = "lafti";

  if ($conn = mysqli_connect($server, $user, $pass, $bd)) {
      // echo"deu certo patrao";
   }else{
    echo "erro";
 }
