<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Edit Questions</title>
	<link rel="stylesheet" href="../Window.css" />
	<link rel="stylesheet" href="BEWindow.css" />
	<link rel="stylesheet" href="../Form.css" />
	<link rel="stylesheet" href="EditFields.css" />
	<link rel="stylesheet" href="EditQ.css" />
</head>
<body>
	<section>
		<form method="get" target="_blank" action="EditThisQ.php">
        	<input type="number" name="qn" placeholder="Question Number" />
        	<button type="submit" name="SQ">Show Question</button>
    	</form>
    	
    	<form method="post" 
    	action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        	<input type="text" name="find" placeholder="Keyword to search for" />
        	<button type="submit" name="search">Search</button>
    	</form>
	</section>

<?php
require_once '../ValidateInput.php';

$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn)
    die("Connection failed : ".mysqli_connect_error());

if($_SERVER['REQUEST_METHOD']=='POST')  {
    extract($_POST);
    if(isset($search)):
        $find=testInput($find);
        $q="SELECT QuesID FROM ".
        "(SELECT QuesID FROM Questions WHERE CONCAT(Question, '', Opt1, '', ".
        "Opt2, '', Opt3, '', Opt4) LIKE '%".$find."%' UNION ".
        "SELECT Q.QuesID FROM Questions Q, Languages L, LangTags LT ".
        "WHERE Q.QuesID=LT.QuesID AND L.LangID=LT.LangID and LangName ".
        "LIKE '%".$find."%' UNION ".
        "SELECT Q.QuesID FROM Questions Q, Topics T, TopicTags TT WHERE ".
        "Q.QuesID=TT.QuesID AND T.TopicID=TT.TopicID and TopicName ".
        "LIKE '%".$find."%') AS T ORDER BY QuesID";
        $rs=mysqli_query($conn, $q);
        if($rs && mysqli_num_rows($rs)): ?>
        	<div style="color:#AAA;text-align:center;">
				(Click on the question no. to view/edit the question)
			</div>
            <section class="qn-con">
            <?php while(($r=mysqli_fetch_assoc($rs))): ?>
        		<div class="qn" onclick="passToForm(this)">
        			<?php echo $r['QuesID']; ?>
        		</div>
        	<?php endwhile; ?>
            </section>
    	<?php endif; 
    endif; ?>
    <div style="display:none">
    	<form method="get" target="_blank" action="EditThisQ.php">
        	<input type="hidden" name="qn" value="" />
        	<button type="submit" name="SQ">Show Question</button>
    	</form>
    </div>
<?php }
mysqli_close($conn);
?>

	<script src="OpenInFrame.js"></script>
	<script>
	function passToForm(x)	{
		var qn=document.getElementsByName("qn")[1];
		qn.value=x.innerHTML;
		var sq=document.getElementsByName("SQ")[1];
		sq.click();
	}
	</script>
</body>
</html>