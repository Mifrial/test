<?php
    header('Content-Type: text/html; charset=utf-8');

    $mysqli = new mysqli("localhost", "id12577173_testuser", "123456", "id12577173_htea_test");
   
    if (mysqli_connect_errno())
    { 
        exit("<p><strong>Ошибка подключения к БД</strong>. Описание ошибки: ".mysqli_connect_error()."</p>"); 
    }
 
    $mysqli->set_charset('utf8');
?>