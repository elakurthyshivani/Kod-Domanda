<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Languages</title>
	<link rel="stylesheet" href="Window.css" />
	<link rel="stylesheet" href="DisplayLogo.css" />
	<link rel="stylesheet" href="Languages.css" />
</head>
<body>
<?php
$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn)    die("Connection failed: ".mysqli_connect_error());

$q="SELECT LangName, LogoURL FROM Languages";
$r=mysqli_query($conn, $q);
?>
	<div id="background"></div>
	
	<div id="display-logo">
		<img src="images/logo.png" onclick="window.location='Home.html'" />
	</div>

	<div id="main">
		<?php 
    	if(mysqli_num_rows($r)>0)  {
    	    while($row=mysqli_fetch_assoc($r)) {
    	?>
		<a href="QuizList.php?lang=<?php echo $row['LangName']; ?>">
			<img src="<?php echo $row['LogoURL']; ?>" 
				alt="<?php echo $row['LangName']; ?>"/>
			<br/><?php echo $row['LangName']; ?>
		</a>
		<?php
	       }
	    }
	    mysqli_close($conn);
	    ?>
	</div>
</body>
</html>