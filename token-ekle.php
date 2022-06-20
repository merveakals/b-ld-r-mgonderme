<?php
    require 'inc/config.php';
    
    /** veritabanına daha önce eklenmiş mi bakalım */
    $token = $_GET['token'];
    $kontrol = DB::getRow("SELECT * FROM tokenlar WHERE token='$token'");
    if ( !$kontrol ) 
    {
        DB::query("INSERT INTO tokenlar(token) VALUES('$token')");    
    }


?>  
