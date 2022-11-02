<?php require_once __DIR__.'/../assets/vendor/autoload.php';
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
$converter = new AnsiToHtmlConverter();
$result_number = 0;
$result_list = array();
for ($i = 0; $i <= 365; $i++) {
    $date = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-$i, date("Y")));
	$filename = "../logs/backup_script-" . $date . ".log";
	$result = file_exists($filename);
	if ($result == True)
	{
		$result_number = $result_number + 1;
		if ($result_number == 1)
		{
			//echo "$date gefunden";
			$first_log = $filename;
			$first_log_date = $date;
		}
		else
		{
			$result_list += array($date => $filename);
		}
	}
}

?>
<h2>Last Backup: <?php echo $first_log_date ?></h2>
<?php
$fh = fopen($first_log, 'r');
$pageText = fread($fh, 25000);
$erg = $converter->convert($pageText);
$erg = str_replace(" color: white"," color: black",$erg);
$erg = str_replace("background-color: black;","",$erg);
echo nl2br($erg);
?>

|<>|

<?php
$result_list["2022-10-19"];
foreach($result_list as $x => $x_value) {
  //echo "Key=" . $x . ", Value=" . $x_value;
  echo "<a href=\"show-log?date=$x\">$x</a>";
  echo "<br>";
}
?>

