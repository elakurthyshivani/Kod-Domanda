<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Backend</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/
	font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="../Window.css" />
	<link rel="stylesheet" href="BEWindow.css" />
	<link rel="stylesheet" href="Start.css" />
	<link rel="stylesheet" href="../Form.css" />
	<link rel="stylesheet" href="SideNav.css" />
</head>
<body>
<?php 
$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn)
    die("Connection failed : ".mysqli_connect_error());
    
$q="SELECT COUNT(*) FROM Authenticate";
$rs=mysqli_query($conn, $q);
$n=0;
if($rs && mysqli_num_rows($rs)>0)
    $n=mysqli_fetch_all($rs)[0][0];
    
mysqli_close($conn);
?>
<!-- Password container -->
	<div id="p-con">
		<form>
		<?php if($n==0): ?>
			<label>Create a password before getting started!</label>
		<?php endif; ?>
			<input type="password" placeholder="Enter password" />
			<div class="Error"></div>
		<?php if($n==0): ?>
			<input type="password" placeholder="Re-enter password" />
			<div class="Error"></div>
		<?php endif; ?>
			<button type="button" onclick="showBBox(<?php echo $n; ?>)">
				Continue
			</button>
		</form>
	</div>
	
<!-- Body container -->
	<div id="b-con">
		<nav>
			<div>
			<a href="AddL.php" target="i" onclick="makeActive(1)">Add Language</a>
			<a href="EditL.php" target="i" onclick="makeActive(2)">Edit Languages</a>
			<a href="AddT.php" target="i" onclick="makeActive(3)">Add Topic</a>
			<a href="EditT.php" target="i" onclick="makeActive(4)">Edit Topics</a>
			</div>
			<div>
			<a href="AddQ.php" target="i" onclick="makeActive(5)">Add Question</a>
			<a href="EditQ.php" target="i" onclick="makeActive(6)">Edit Questions</a>
			<a href="ViewC.php" target="i" onclick="makeActive(7)">View Contacted</a>
			<a href="ViewF.php" target="i" onclick="makeActive(8)">View Feedback</a>
			</div>
		</nav>
		
		<iframe name="i" height="100%" width="80%">
		Your browser doesn't support frames. Please try again with another browser.
		</iframe>
	</div>
	
	<script src="../FormValidations.js"></script>
	<script src="Start.js"></script>
</body>
</html>