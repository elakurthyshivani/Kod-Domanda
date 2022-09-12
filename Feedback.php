<?php
require_once 'ValidateInput.php';

$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn)
    die("Connection failed : ".mysqli_connect_error());
    
    if($_SERVER["REQUEST_METHOD"]=="POST") {
        extract($_POST);
        if(isset($sf)):
        $name=testInput($name);
        $msg=testInput($msg);
        $q="INSERT INTO Feedback(Name, Message) VALUES ".
            "('".$name."', '".$msg."')"; ?>
    	<div style="text-align:center">
    	<?php if(mysqli_query($conn, $q)):
            echo "Thank you ".$name." for providing the feedback! ".
    	   "It means a lot to us!";
        else: 
            echo "Error occurred! Please try again.";
        endif; ?>
        </div>
    <?php endif;
}

mysqli_close($conn);
?>