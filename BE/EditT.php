<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Edit Topics</title>
	<link rel="stylesheet" href="../Window.css" />
	<link rel="stylesheet" href="BEWindow.css" />
	<link rel="stylesheet" href="../Form.css" />
	<link rel="stylesheet" href="EditFields.css" />
</head>
<body>
<?php
require_once '../ValidateInput.php';

$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn)
    die("Connection failed : ".mysqli_connect_error());

if($_SERVER['REQUEST_METHOD']=='POST')  {
    extract($_POST);
    if(isset($e))   {
        $name=testInput($name);
        $q="UPDATE Topics SET TopicName='".$name."' WHERE TopicID=".$h;
        if(mysqli_query($conn, $q)): ?>
        	<script>window.alert("Updated successfully.");</script>
        <?php else: ?>
        	<script>window.alert("Error occurred.");</script>
        <?php endif;
    }
}
    
$q="SELECT * FROM Topics ORDER BY TopicID";
$rs=mysqli_query($conn, $q);
if($rs && mysqli_num_rows($rs)) {
?>
	<div style="color:#AAA;text-align:center;">
		(Click on the values to edit)
	</div>
	
	<?php while(($r=mysqli_fetch_assoc($rs))): ?>
    	<section>
        	<div class="qn"><?php echo $r['TopicID']; ?></div>
        	<form method="post" 
        	action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        		<label>Topic Name</label>
				<input type="text" placeholder="Name" name="name"
				value="<?php echo stripslashes($r['TopicName']); ?>" />
        		<input type="hidden" name="h" value="<?php echo $r['TopicID']; ?>" />
        		<button type="submit" name="e">Save</button>
        	</form>
        </section>
<?php endwhile;
}
mysqli_close($conn);
?>

	<script src="OpenInFrame.js"></script>
</body>
</html>