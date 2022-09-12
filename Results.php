<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Results</title>
	<link rel="stylesheet" href="Window.css" />
	<link rel="stylesheet" href="DisplayLogo.css" />
	<link rel="stylesheet" href="Results.css" />
</head>
<body>
	<div id="display-logo">
		<img src="images/logo.png" onclick="window.location='Home.html'" />
	</div>
	
<?php if($_SERVER["REQUEST_METHOD"]=="POST")    {
    $a=explode(",", $_POST['ans']);# $a contains values between 0 and 3.
    $q=explode(",", $_POST['ques']);
    $fq=[];# Failed questions.
    $ao=[];# Correct answer option.
    $aon=[];# Answer option number.
    $c=[];# Is Correct array.
    $s=0;# Score.
    $n=count($q);
    if(isset($_POST['f']))    {
        $conn=mysqli_connect("localhost", "root", "", "koddomanda");
        if(!$conn)  die("Connection failed: ".mysqli_connect_error());
        
        for($i=0; $i<$n; $i++):
            $qu="SELECT Question, Opt1, Opt2, Opt3, Opt4, Ans FROM ".
            "Questions WHERE QuesID=".$q[$i];
            $rs=mysqli_query($conn, $qu);
            if(mysqli_num_rows($rs)>0):
                $r=mysqli_fetch_assoc($rs);
                $a[$i]=($a[$i]==-1?-1:$a[$i]+1);
                if($a[$i]==$r['Ans']):
                    $s++;
                    $c[$i]=1;
                else:
                    $c[$i]=0;
                    $fq[$q[$i]]=$r['Question'];
                    $ao[$q[$i]]=$r['Opt'.$r['Ans']];
                    $aon[$q[$i]]=$r['Ans'];
                endif;
            endif;
        endfor;
        mysqli_close($conn);
    }
?>
	
	<div id="main">
		<div id="score-con" class="card">
			<div class="text">Your result is</div>
			<div id="score"><?php echo $s; ?></div>
			<div class="text">out of <?php echo $n; ?>.</div>
			<div class="text">
			<?php if($s==$n):
			     echo "Congratulations! You got it all correct!";
			elseif($s>$n/2):
			     echo "Good! That was close!";
			else:
			     echo "Cheer up! You can do it better in the coming quizzes!";
			endif;?>
			</div>
			<?php if($s!=$n): ?>
			<div class="text" style="font-size:1.5em;">
				Click on next to look at the questions which you've done wrong.
			</div>
			<?php endif; ?>
		</div>
		<?php for($i=0; $i<$n; $i++):
        if($c[$i]==0):?>
		<div class="ques-con card">
			<pre class="ques">
<span><?php echo "Question ".($i+1); ?></span>
<?php echo stripslashes($fq[$q[$i]]); ?></pre>
			<pre class="ans" title="Answer">
<span><?php echo "Option ".$aon[$q[$i]]; ?></span>
<?php echo stripslashes($ao[$q[$i]]); ?></pre>
		</div>
		<?php endif;
		endfor;
		?>
		<div id="prev" onclick="changeCard(-1)">Prev</div>
		<div id="next" onclick="changeCard(1)">Next</div>
		<div id="fini" onclick="window.history.go(-2)">Finish</div>
	</div>
	
<?php 
}else   { ?>
	<div style="text-align:center">No results to show.</div>
<?php } ?>
	<script src="Results.js"></script>
</body>
</html>