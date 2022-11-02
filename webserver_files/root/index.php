<head>
<title>SFTP-Backup logs</title>
<meta name="title" content="example" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript">
     $(function(){
       $.get("output.php", function(data){
		var result= data.split('|<>|');
		var last_log=result[0];
		var overview=result[1];
		document.getElementById("main").innerHTML=last_log;   
       document.getElementById("overview").innerHTML=overview;         
       });
    });
</script>

<body>
<h1> Overview </h1>
<div id="main" class="log_block">
Loading...
</div>
<div id="overview" class="log_block">
Loading...
</div>
</body>