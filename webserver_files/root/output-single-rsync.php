<?php 
require_once __DIR__.'/../assets/vendor/autoload.php';
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
$converter = new AnsiToHtmlConverter();
$date = $_GET['date'];
$date = basename("$date");
$filename = "../logs/rsync-" . $date . ".log";
?>
<h2>Rsync logs for backup of <?php echo $date ?></h2>
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
