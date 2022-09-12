<?php
require_once 'ValidateInput.php';

$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn)
    die("Connection failed : ".mysqli_connect_error());

if($_SERVER["REQUEST_METHOD"]=="POST") {
    extract($_POST);
    if(isset($send)): 
        $name=testInput($name);
        $email=testInput($email);
        $subject=testInput($subject);
        $msg=testInput($msg);
    	$q="INSERT INTO Contacted(Name, Email, Subject, Message) VALUES ".
        "('".$name."', '".$email."', '".$subject."', '".$msg."')"; ?>
    	<div style="text-align:center">
    	<?php if(mysqli_query($conn, $q)):
            echo "Thank you ".$name." for contacting us! We'll reply you soon!";
        else: 
            echo "Error occurred! Please try again.";
        endif; ?>
        </div>
    <?php endif;
}

mysqli_close($conn);
?>