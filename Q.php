<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Domanda</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/
	font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="Window.css" />
	<link rel="stylesheet" href="Q.css" />
	<link rel="stylesheet" href="QNav.css" />
	<link rel="stylesheet" href="QQCon.css" />
	<link rel="stylesheet" href="QACon.css" />
	<link rel="stylesheet" href="QOtherCon.css" />
	<script>ques=[];</script>
</head>
<body>
<?php 
$conn=mysqli_connect("localhost", "root", "", "koddomanda");

if(!$conn) die("Connection failed: ".mysqli_connect_error());

$a=[];

if(array_key_exists('rand', $_GET) && $_GET['rand']==1):
    $q="SELECT * FROM Questions ORDER BY RAND() LIMIT 10";
elseif(array_key_exists('lang', $_GET) && array_key_exists('n', $_GET)):
    $q="SELECT Q.* FROM Questions Q, LangTags L, Languages La WHERE ".
    "Q.QuesID=L.QuesID AND L.LangID=La.LangID AND La.LangName='".$_GET['lang'].
    "' LIMIT ".(($_GET['n']-1)*10).", 10";  

elseif(array_key_exists('topic', $_GET) && array_key_exists('n', $_GET)):
    $q="SELECT Q.* FROM Questions Q, TopicTags TT, Topics T WHERE ".
        "Q.QuesID=TT.QuesID AND TT.TopicID=T.TopicID AND T.TopicName='".
        $_GET['topic']."' LIMIT ".(($_GET['n']-1)*10).", 10";  

else: ?>
	<div style='text-align:center'>
		<?php die("No Such Page"); ?>
	</div>
<?php endif;

$r=mysqli_query($conn, $q);

if(($r && $noq=mysqli_num_rows($r))>0):
    while($row=mysqli_fetch_assoc($r))    array_push($a, $row);

else: ?>
	<div style='text-align:center'>
		<?php die("This page does not exist"); ?>
	</div>
<?php endif; 

for($i=0; $i<$noq; $i++):
    $q="SELECT LangName AS T FROM LangTags LT, Languages L WHERE QuesID="
	    .$a[$i]['QuesID']." AND L.LangID=LT.LangID";
    $r=mysqli_query($conn, $q);
    $t=getArray($r, []);
    
    $q="SELECT TopicName AS T FROM TopicTags TT, Topics T WHERE QuesID="
    .$a[$i]['QuesID']." AND T.TopicID=TT.TopicID";
    $r=mysqli_query($conn, $q);
    $t=getArray($r, $t);
    
    $a[$i]['Tags']=$t;
    ?>
    <script>ques[<?php echo $i; ?>]=<?php echo $a[$i]['QuesID']; ?></script>
<?php endfor;

mysqli_close($conn);

function getArray($r, $a)   {
    if($r && mysqli_num_rows($r)>0)  {
        while($row=mysqli_fetch_assoc($r))    array_push($a, $row['T']);
    }
    return $a;
}
?>
	<!-- QUESTION NUMBERS NAV -->
	<nav>
	<?php for($i=1; $i<=$noq; $i++): ?>
		<div class='qn' onclick='displayQ(<?php echo $i-1; ?>)'>
			<div><?php echo $i; ?>&nbsp;<span>&bull;</span></div>
		</div>
	<?php endfor; ?>
	</nav>
	
	<!-- QUESTION AND TIPS CONTAINER -->
	<div id='q-con'>
    <?php 
    for($i=0; $i<$noq; $i++)  {
    ?>	
		<pre class='q'>
<?php echo stripslashes($a[$i]['Question']); ?>
		</pre>
		
		<div class='tag'>
			Tags<br />
		<?php for($j=0, $n=count($a[$i]['Tags']); $j<$n; $j++): ?>
			<span>#<?php echo $a[$i]['Tags'][$j]; ?></span>
		<?php endfor; ?>
		</div>
	<?php }	?>
	</div>
	
	<!-- OPTIONS CONTAINER -->
	<div id='a-con'>
	<?php for($i=0; $i<$noq; $i++) { ?>
		<div class='a'>
    	<?php for($j=1; $j<=4; $j++)   { ?>
    		<div class='o-con<?php echo $i+1; ?>'
    		onclick="selectOption(<?php echo $i, ", ", $j-1; ?>)">
    			<input type='radio' name='o<?php echo $i+1; ?>'>
    			<pre class='o'>
<?php echo stripslashes($a[$i]['Opt'.$j]); ?>
    			</pre>
    		</div>
    	<?php } ?>
    	</div>
    <?php } ?>
	</div>
	
	<!-- OTHER CONTAINER -->
	<div id="other-con">
    	<button id='tip' title="Tips" onclick="showTips()">
    		<i class="fa fa-lightbulb-o" aria-hidden="true"></i>
    	</button>
    	
    	<button id='prev' title="Previous Question" 
    	onclick="pnQ(-1, <?php echo $noq; ?>)">
    		<span>&lt;</span>
    	</button>
    	
    	<button id='next' title="Next Question" 
    	onclick="pnQ(1, <?php echo $noq; ?>)">
    		<span>&gt;</span>
    	</button>
    	
    	<form name="eq" action="Results.php" method="POST" 
    	onsubmit="return endQuiz()">
    		<input type="hidden" name="ques" />
        	<input type="hidden" name="ans" />
        	<button name="f" type="submit"
        	id='fin' title="Finish Quiz">
        		<i class="fa fa-check" aria-hidden="true"></i>
        	</button>
        </form>
        
        <div id='tip-con'>
    		<span onclick="closeTips()">x</span>
    		<pre>
    Question Numbers Navigation :
    	- Click on a number n to view the nth question.
    	- The red circles beside the numbers indicate the not attempted questions.
    	- The green circles beside the numbers indicate the attempted questions.
    	
    Tags :
    <i class="fa fa-lightbulb-o" aria-hidden="true"></i> :
    	- Mouse over the tags section to view the tags of this question.
    	
    &lt; :
    	- Click on this to go to the question present before this question.
    
    &gt; :
    	- Click on this to go to the question present after this question.
    
    <i class="fa fa-check" aria-hidden="true"></i> :
    	- Click on this to finish the quiz.
    		</pre>
    	</div>    	
    </div>
	
	<script src='Q.js'></script>
	<script>
	var b=document.getElementsByTagName("button");
	window.onload=window.onresize=function()	{
		for(var i=0; i<b.length; i++)
			b[i].style.height=b[i].scrollWidth+"px";
	}
	</script>
</body>
</html>