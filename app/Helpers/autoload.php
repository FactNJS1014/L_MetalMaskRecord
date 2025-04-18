<?php
$files = glob(__DIR__ . '/*Helper.php'); // get all PHP files in the directory
foreach ($files as $file) {
   $fileName = (string) $file;
   if(strpos($fileName, 'Helper.php') !== false) {
       require_once $fileName; // skip the autoload.php file itself
   }
}
?>
