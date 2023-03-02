<?php 
require_once __DIR__.'/../assets/vendor/autoload.php';
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
$converter = new AnsiToHtmlConverter();
$date = $_GET['date'];
$date = basename("$date");
$filename = "../logs/backup_script-" . $date . ".log";
?>
<h2>Logs for backup of <?php echo $date ?> <a href="/show-rsync-log?date=<?php echo $date ?>">(rsync)</a></h2>
<?php
$fh = fopen($filename, 'r');
if(filesize($filename) > 0) {
  $pageText = fread($fh, filesize($filename));
  $erg = $converter->convert($pageText);
  $erg = str_replace("color: white","color: black",$erg);
  $erg = str_replace("background-color: black;","",$erg);
  echo nl2br($erg);
} else {
  echo "Error. This log does not exist.";
}
?>
