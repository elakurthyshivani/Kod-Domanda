<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Topics</title>
	<link rel="stylesheet" href="Window.css" />
	<link rel="stylesheet" href="DisplayLogo.css" />
	<link rel="stylesheet" href="Topics.css" />
</head>
<body>
	<div id="display-logo">
		<img src="images/logo.png" onclick="window.location='Home.html'" />
	</div>
	
	<div id="main">
		<?php 
    	$conn=mysqli_connect("localhost", "root", "", "koddomanda");
    	
    	if(!$conn) die("Connection failed : ".mysqli_connect_error());
    	
    	$q="SELECT TopicName FROM Topics ORDER BY TopicName";
    	$rs=mysqli_query($conn, $q);
    	if($rs && mysqli_num_rows($rs)>0)  {
    	   $rows=mysqli_fetch_all($rs);
    	   for($i=0; $i<4; $i++): ?>
        	   <section>
        	   <?php 
        	   for($j=$i; $j<count($rows); $j+=4): ?>
        	   	   <a href="QuizList.php?topic=<?php echo $rows[$j][0]; ?>">
        	   	   		<?php echo $rows[$j][0]; ?>
        	   	   </a>
        	   <?php endfor; ?>
        	   </section>
    	   <?php endfor;
    	}
    	mysqli_close($conn);
    	?>
	</div>
	
	<script src="SetColors.js"></script>
	<script>
	setColors(document.getElementsByTagName("a"), 1);
	</script>
</body>
</html>