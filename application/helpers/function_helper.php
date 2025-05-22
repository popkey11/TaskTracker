<?php
// ฟังก์ชั่น Dbug
if (!function_exists('dbug')) {
    function dbug($var)
    {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
        exit;
    }
}
