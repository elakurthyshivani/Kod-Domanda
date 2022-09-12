<?php
if(array_key_exists("p", $_POST))  {
    $p=$_POST['p'];
    $n=$_POST['n'];
    
    if(!isset($p))  die;
    
    $conn=mysqli_connect("localhost", "root", "", "koddomanda");
    if(!$conn)
        die("Connection failed : ".mysqli_connect_error());
        
    if($n==0)   {
        $q="INSERT INTO Authenticate VALUES ('".$p."')";
        echo (mysqli_query($conn, $q)?"1":"0");
        
        mysqli_close($conn);
        die;
    }
    
    $q="SELECT Password FROM Authenticate";
    $rs=mysqli_query($conn, $q);
    if($rs && mysqli_num_rows($rs)>0)   {
       
        if(strcmp(mysqli_fetch_assoc($rs)['Password'], $p)==0)    echo "1";
        else    echo "0";
    }
    
    mysqli_close($conn);
    
}
?>