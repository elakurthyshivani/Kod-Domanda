<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Add Language</title>
	<link rel="stylesheet" href="../Window.css" />
	<link rel="stylesheet" href="BEWindow.css" />
	<link rel="stylesheet" href="../Form.css" />
</head>
<body>
<?php
require_once '../ValidateInput.php';

$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn)
    die("Connection failed : ".mysqli_connect_error());

if($_SERVER["REQUEST_METHOD"]=="POST") {
    extract($_POST);
    if(isset($a))    {
        $name=testInput($name);
        $url=testInput($url);
        $n=0;
        
        $q="SELECT COUNT(*) AS c FROM Languages";
        $r=mysqli_query($conn, $q);
        if(mysqli_num_rows($r)>0) {
            $row=mysqli_fetch_assoc($r);
            $n=$row["c"]+1;
        }
        
        $q="INSERT INTO Languages VALUES (" . $n . ", '" . $name."', '".
            $url . "');";
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
    
	<form method="post" name="lform" onsubmit="return validateLForm()"
	action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Language Name</label>
		<input type="text" placeholder="Name" name="name" />
		<div class="Error">
			* Enter a valid name containing alphabets, numbers,
			dots and spaces only.
		</div>
		<label>Logo Relative URL</label>
		<input type="text" placeholder="URL" name="url" />
		<div class="Error">
			* Enter a valid URL.
		</div>
		<button type="submit" name="a">Add</button>
	</form>
	
	<script src="../FormValidations.js"></script>
	<script src="OpenInFrame.js"></script>
	<script>
	function validateLForm()	{
		var n=document.forms["lform"]["name"];
		var u=document.forms["lform"]["url"];
		if(!validateName(n) || !validateURL(u))	return false;
		return true;
	}
	</script>
</body>
</html>