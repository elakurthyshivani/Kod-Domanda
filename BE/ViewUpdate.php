<?php
if($_SERVER['REQUEST_METHOD']=="GET")   {    
    $conn=mysqli_connect("localhost", "root", "", "koddomanda");
    if(!$conn)
        die("Connection failed : ".mysqli_connect_error());
        
    $q="UPDATE ".$_GET['table']." SET IsRead=".$_GET['isread']." WHERE ".
    (ucfirst($_GET['table'])=="Contacted"?"MID":"FID")."=".$_GET['n'];
    $rs=mysqli_query($conn, $q);
    
    mysqli_close($conn);
}
?>