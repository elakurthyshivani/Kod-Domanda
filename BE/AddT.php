<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Add Topic</title>
	<link rel="stylesheet" href="../Window.css" />
	<link rel="stylesheet" href="BEWindow.css" />
	<link rel="stylesheet" href="../Form.css" />
</head>
<body>
<?php
require_once '../ValidateInput.php';

$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn) {
    die("Connection failed : ".mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"]=="POST") {
    extract($_POST);
    if(isset($a))    {
        $name=testInput($name);
        $n=0;
        
        $q="SELECT COUNT(*) AS c FROM Topics";
        $r=mysqli_query($conn, $q);
        if(mysqli_num_rows($r)>0) {
            $row=mysqli_fetch_assoc($r);
            $n=$row["c"]+1;
        }
        
        $q="INSERT INTO Topics VALUES (" . $n . ", '" . $name . "');";
?>
        <?php if(mysqli_query($conn, $q)): ?>
    		<script>window.alert("Inserted into the database successfully.");</script>
    	<?php else: ?>
    		<script>window.alert("Error occurred.");</script>
    	<?php endif;
    }  
}
mysqli_close($conn);
?>

	<form method="post" name="tform" onsubmit="return validateTForm()"
	action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Topic Name</label>
		<input type="text" placeholder="Name" name="name" />
		<div class="Error">
			* Enter a valid name containing alphabets, numbers,
			dots and spaces only.
		</div>
		<button type="submit" name="a">Add</button>
	</form>
	
	<script src="../FormValidations.js"></script>
	<script src="OpenInFrame.js"></script>
	<script>
	function validateTForm()	{
		var n=document.forms["tform"]["name"];
		if(!validateName(n))	return false;
		return true;
	}
	</script>
</body>
</html>