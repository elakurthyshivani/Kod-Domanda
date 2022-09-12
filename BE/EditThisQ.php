<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Edit Question</title>
	<link rel="stylesheet" href="../Window.css" />
	<link rel="stylesheet" href="BEWindow.css" />
	<link rel="stylesheet" href="../Form.css" />
	<link rel="stylesheet" href="EditFields.css" />
	<link rel="stylesheet" href="PlusButton.css" />
	<link rel="stylesheet" href="EditThisQ.css" />
</head>
<body>
<?php
require_once '../ValidateInput.php';

$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn)
    die("Connection failed : ".mysqli_connect_error());

if($_SERVER['REQUEST_METHOD']=='POST')  {
    $v=array_merge($_POST);
    unset($v['submit']);
    if(isset($_POST['submit']))    {
        foreach($v as $key=>$value)
            $v[$key]=testInput($value);
        
        $q="UPDATE Questions SET Question='".$v['q']."', Opt1='".$v['o1'].
        "', Opt2='".$v['o2']."', Opt3='".$v['o3']."', Opt4='".$v['o4'].
        "', Ans=".$v['a'][strlen($v['a'])-1]." WHERE QuesID=".$v['h'];
        
        if(mysqli_query($conn, $q)): ?>
        	<script>window.alert("Updated successfully.");</script>
        <?php else: ?>
        	<script>window.alert("Error occurred.");</script>
        <?php endif;
    }
}

if(isset($_GET['SQ']))    {
    $qn=$_GET['qn'];
    $q="SELECT * FROM Questions WHERE QuesID=".$qn;
    $rs=mysqli_query($conn, $q);
    if($rs && mysqli_num_rows($rs)) { ?>
    	<div style="color:#AAA;text-align:center;">
    		(Click on the values to edit)
    	</div>
    	
    	<?php while(($r=mysqli_fetch_assoc($rs))):
        	$q="SELECT LangName FROM Languages L1, ".
        	"(SELECT LangID FROM LangTags WHERE QuesID=".$r['QuesID'].") AS L2 ".
        	"WHERE L1.LangID=L2.LangID";
        	$innerrs=mysqli_query($conn, $q);
        	$lt=[];
        	if($innerrs && mysqli_num_rows($innerrs))
    	        $lt=mysqli_fetch_all($innerrs);
    	
    	    $q="SELECT TopicName FROM Topics T1, ".
    	    "(SELECT TopicID FROM TopicTags WHERE QuesID=".$r['QuesID'].") AS T2 ".
    	    "WHERE T1.TopicID=T2.TopicID";
    	    $innerrs=mysqli_query($conn, $q);
    	    $tt=[];
    	    if($innerrs && mysqli_num_rows($innerrs))
    	        $tt=mysqli_fetch_all($innerrs);
    	?>

    	<section>
        	<div class="qn"><?php echo $r['QuesID']; ?></div>
        	<form method="post" 
        	action="EditThisQ.php?qn=<?php echo $qn; ?>&SQ=">
        		<label>Question</label>
        		<div style="color:#AAA;">
        			(For every single \, enter \\)
        		</div>
        		<textarea name="q" rows="6" placeholder="Enter your question"><?php 
        		echo stripslashes($r['Question']); ?></textarea>
        		
        		<label>Option 1</label>
        		<textarea name="o1" rows="2" placeholder="Option 1"><?php 
        		echo stripslashes($r['Opt1']); ?></textarea>
        		<label>Option 2</label>
        		<textarea name="o2" rows="2"  placeholder="Option 2"><?php 
        		echo stripslashes($r['Opt2']); ?></textarea>
        		<label>Option 3</label>
        		<textarea name="o3" rows="2"  placeholder="Option 3"><?php 
        		echo stripslashes($r['Opt3']); ?></textarea>
        		<label>Option 4</label>
        		<textarea name="o4" rows="2"  placeholder="Option 4"><?php 
        		echo stripslashes($r['Opt4']); ?></textarea>
        		
        		<label>Correct Answer</label>
        		<select name="a" >
        		<?php for($x=1; $x<=4; $x++): ?>
        			<option <?php if($x==$r['Ans']) { ?>selected="selected"<?php }?>>
        				Option <?php echo $x; ?>
        			</option>
        		<?php endfor; ?>
        		</select>
        		
        		<!-- 
        		<label>Image URL</label>
        		<input name="u" type="url" placeholder="URL" />  -->
        		
        		<label>Language Tags</label>
        		<div id="lt">
        		<?php for($x=0; $x<count($lt); $x++): ?>
        			<input name="lt<?php echo $x+1; ?>" type="text" placeholder="Tag" 
        			value="<?php echo $lt[$x][0]; ?>" />
        		<?php endfor; ?>
        		</div>
        		<div class="button" onclick="addNewTag('lt')">+</div>
        		
        		<label>Topic Tags</label>
        		<div id="tt">
            		<div style="color:#AAA;">
            			(Use one tag in each and each tag can contain spaces)
            		</div>
            	<?php for($x=0; $x<count($tt); $x++): ?>
        			<input name="tt<?php echo $x+1; ?>" type="text" placeholder="Tag"
        			value="<?php echo $tt[$x][0]; ?>" />
        		<?php endfor; ?>
        		</div>
        		<div class="button" onclick="addNewTag('tt')">+</div>
        		
        		<input type="hidden" name="h" value="<?php echo $r['QuesID']; ?>" />
        		<button type="submit" name="submit">Save</button>
        	</form>
        </section>
<?php endwhile;
    }
    else { ?>
        <div style='text-align:center'>
        	<?php die("No such question"); ?>
		</div>
    <?php }
}

mysqli_close($conn);
?>
	<script src="AddTags.js"></script>
	<script src="EditThisQ.js"></script>
</body>
</html>