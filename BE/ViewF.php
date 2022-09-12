<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>View Feedback</title>
	<link rel="stylesheet" href="../Window.css" />
	<link rel="stylesheet" href="BEWindow.css" />
	<link rel="stylesheet" href="ViewCOrF.css" />
</head>
<body>
<?php 
require_once '../ValidateInput.php';

$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn)
    die("Connection failed : ".mysqli_connect_error());

$q="SELECT * FROM Feedback ORDER BY IsRead, FID DESC";
$rs=mysqli_query($conn, $q);
$c=0;
if($rs && ($tn=mysqli_num_rows($rs)))
    $c=mysqli_fetch_all($rs); 

$nobc=floor($tn/10)+($tn%10==0?0:1);
?>
	<nav>
	<?php for($i=1; $i<=$nobc; $i++): ?>
		<div class="u-nav-i" onclick="makeActive(<?php echo $i; ?>)">
			<?php echo $i; ?>
		</div>
		<?php if($i!=$nobc) { ?> | <?php }
	endfor; ?>
	</nav>
	
<?php for($i=1; $i<=$nobc; $i++): ?>	
	<section>
	<?php for($j=($i-1)*10; $j<$tn && $j<$i*10; $j++): ?>
		<div class="group">
			<div class="mid"><?php echo $c[$j][0]; ?></div>
    		<div class="name"><?php echo $c[$j][1]; ?></div>
    		<div class="message"><?php echo $c[$j][2]; ?></div>
    		<button onclick="toggleValues(this, <?php echo $c[$j][0]; ?>)"><?php 
    		     echo ($c[$j][3]==0?"Unread":"Read"); ?></button>
    		<input type="hidden" value="0" />
		</div>
	<?php endfor; ?>
	</section>
<?php endfor; ?>
	
	<nav>
	<?php for($i=1; $i<=$nobc; $i++): ?>
		<div class="l-nav-i" onclick="makeActive(<?php echo $i; ?>)">
			<?php echo $i; ?>
		</div>
		<?php if($i!=$nobc) { ?> | <?php }
	endfor; ?>
	</nav>
<?php 
?>

	<script src="OpenInFrame.js"></script>
	<script>
	var un=document.getElementsByClassName("u-nav-i");
	var ln=document.getElementsByClassName("l-nav-i");
	var section=document.getElementsByTagName("section");
	var cur=1;

	makeActive(1);
	
	function makeActive(newcur)	{
		un[cur-1].className=un[cur-1].className.replace(" active", "");
		ln[cur-1].className=ln[cur-1].className.replace(" active", "");
		section[cur-1].className="";
		un[newcur-1].className+=" active";
		ln[newcur-1].className+=" active";
		section[newcur-1].className="active";
		cur=newcur;
	}

	function toggleValues(v, n)	{
		v.innerHTML=(v.innerHTML=="Read"?"Unread":"Read");
		
		x=new XMLHttpRequest();
		x.onreadystatechange=function()	{
			if(this.readyState==4 && this.status==200)	{}
		};
		x.open("GET", "ViewUpdate.php?table=Feedback&n="+n+"&isread="+
				(v.innerHTML=="Read"?1:0), true);
		x.send();
	}
	</script>
</body>
</html>