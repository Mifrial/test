<?php
if (isset($_POST['val']) && $_POST['val'] != '')
{
    require_once('./dbcon.php');
    $query_result = $mysqli->query("SELECT `url` FROM `CB-CONN` WHERE `id`='1'");
    $row = $query_result->fetch_row();
    $query_result->close();
    $mysqli->close();

    $s = htmlspecialchars($_POST['val']);
    $xml = simplexml_load_file($row[0].$s);

    foreach ($xml->Valute as $val)
    {
        if (((string)$val['ID']) == 'R01239')
        {
            echo $val->Value;
            break;
        }
    }
}
?>