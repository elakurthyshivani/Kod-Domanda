<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Quizzes</title>
	<link rel="stylesheet" href="Window.css" />
	<link rel="stylesheet" href="DisplayLogo.css" />
	<link rel="stylesheet" href="QuizList.css" />
</head>
<body>
	<div id="display-logo">
		<img src="images/logo.png" onclick="window.location='Home.html'" />
	</div>
	
<?php
$conn=mysqli_connect("localhost", "root", "", "koddomanda");

if(!$conn) die("Connection failed: ".mysqli_connect_error());

if(array_key_exists("lang", $_GET)):
    $q="SELECT COUNT(QuesID) AS C FROM LangTags WHERE LangID=(".
    "SELECT LangID FROM Languages WHERE LangName='".$_GET['lang']."')";

elseif(array_key_exists("topic", $_GET)):
    $q="SELECT COUNT(QuesID) AS C FROM TopicTags WHERE TopicID=(".
    "SELECT TopicID FROM Topics WHERE TopicName='".$_GET['topic']."')";

else: ?>
	<div style='text-align:center'>
		<?php die("No such page"); ?>
	</div>
<?php endif;

$rs=mysqli_query($conn, $q);

if(mysqli_num_rows($rs)>0):
    $r=mysqli_fetch_assoc($rs)['C'];
    $n=(int)($r/10)+($r%10==0?0:1);
    $e=($r%10==0?10:$r%10);
    if($n==0): ?>
    	<div style='text-align:center'>
    		<?php die("At present, no related quizzes exist"); ?>
    	</div>
	<?php endif;
endif; ?>

	<div id="background"></div>
	
	<div id="quiz-con">
    <?php 
    for($i=0; $i<$n; $i++):
        if(array_key_exists("lang", $_GET)):
            $q="SELECT DISTINCT TopicName ".
            "FROM (SELECT Q.QuesID FROM Questions Q, Languages L, LangTags LT ".
            "WHERE Q.QuesID=LT.QuesID AND L.LangID=LT.LangID AND L.LangName='".$_GET['lang']
            ."' LIMIT ".($i*10).", 10) AS QU, Topics T, TopicTags TT ".
            "WHERE T.TopicID=TT.TopicID AND QU.QuesID=TT.QuesID";

        elseif(array_key_exists("topic", $_GET)):
            $q="SELECT DISTINCT LangName ".
            "FROM (SELECT Q.QuesID FROM Questions Q, Topics T, TopicTags TT ".
            "WHERE Q.QuesID=TT.QuesID AND T.TopicID=TT.TopicID AND T.TopicName='".
            $_GET['topic']."' LIMIT ".($i*10).", 10) AS QU, Languages L, LangTags LT ".
            "WHERE L.LangID=LT.LangID AND QU.QuesID=LT.QuesID";
        endif;
        $rs=mysqli_query($conn, $q);
    ?>
        <div class="quiz"  onclick="gotoPage(<?php echo $i+1; ?>)">
        	<div class="quiz-no">Quiz <?php echo $i+1; ?></div>
        	
        	<div class="noq" title="No. of questions">
        		<?php echo (($i!=$n-1)?10:$e); ?>
        	</div>
        	
        	<div class="tags">
            <?php while(($r=mysqli_fetch_row($rs))) echo "#", $r[0], " "; ?>
        	</div>        	
        </div>
    <?php endfor; ?>
	</div>
<?php
mysqli_close($conn);
?>
	<script src="SetColors.js"></script>
	<script>
	setColors(document.getElementsByClassName("quiz"), 0.7);
	
	function gotoPage(n)	{
		<?php if(array_key_exists("lang", $_GET)): ?>
			window.location="<?php echo 'Q.php?lang='.$_GET['lang'].'&n='; ?>"+n;
		<?php endif; ?>
		<?php if(array_key_exists("topic", $_GET)): ?>
			window.location="<?php echo 'Q.php?topic='.$_GET['topic'].'&n='; ?>"+n;
		<?php endif; ?>	
	}
	</script>
</body>
</html>