<head>
<title>SFTP-Backup log of <?php echo $date?></title>
<meta name="title" content="example" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript">
     $(function(){
       
       var date=window.location.search.substr(1)
       $.get(`output-single.php?${date}`, function(data){
		document.getElementById("main").innerHTML=data;            
       });
    });
</script>

<body>
<h1>Single log</h1>
<div id="main" class="log_block">
Loading...
</div>
<button type=button onclick="window.location.href='/';">Back</button>
</body>