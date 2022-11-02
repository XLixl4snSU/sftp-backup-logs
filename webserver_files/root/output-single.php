<?php 
require_once __DIR__.'/../assets/vendor/autoload.php';
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
$converter = new AnsiToHtmlConverter();
$date = $_GET['date'];
$date = basename("$date");
$filename = "../logs/backup_script-" . $date . ".log";
?>
<h2>Logs for backup of <?php echo $date ?></h2>
<?php
$fh = fopen($filename, 'r');
$pageText = fread($fh, 25000);
$erg = $converter->convert($pageText);
$erg = str_replace("color: white","color: black",$erg);
$erg = str_replace("background-color: black;","",$erg);
echo nl2br($erg);
?>