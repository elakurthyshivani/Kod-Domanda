<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Add Question</title>
	<link rel="stylesheet" href="../Window.css" />
	<link rel="stylesheet" href="BEWindow.css" />
	<link rel="stylesheet" href="../Form.css" />
	<link rel="stylesheet" href="PlusButton.css" />
</head>
<body>
<?php
require_once '../ValidateInput.php';

$conn=mysqli_connect("localhost", "root", "", "koddomanda");
if(!$conn) {
    die("Connection failed : ".mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $v=array_merge($_POST);
    unset($v['submit']);
    if(isset($_POST['submit']))    {
        foreach($v as $key=>$value)  
            $v[$key]=testInput($value);
        
        $q="INSERT INTO Questions(Question, Opt1, Opt2, Opt3, Opt4, Ans"
           .") VALUES ('".$v['q']."', '".$v['o1']."', '".$v['o2']."', '".
           $v['o3']."', '".$v['o4']."', ".$v['a'][strlen($v['a'])-1].")";
?>
        <?php if(!mysqli_query($conn, $q)): ?>
    		<script>window.alert("Error occurred.");</script>
    	<?php 
    	   exit("");
    	   endif;
        
        $q="SELECT QuesID FROM Questions ORDER BY QuesID DESC ".
        "LIMIT 1";
        $r=mysqli_query($conn, $q);
        $n=0;
        if(mysqli_num_rows($r)>0) {
            $row=mysqli_fetch_assoc($r);
            $n=$row["QuesID"];
        }
        
        foreach($v as $key=>$value) {
            if(strstr($key, "lt")!=FALSE)    {
                $q="INSERT INTO LangTags SELECT ".$n.", LangID ".
                "FROM Languages WHERE LangName LIKE '".$value."'";
        ?>
                <?php if(!mysqli_query($conn, $q)): ?>
                	<script>window.alert("Error occurred. "+
                        	"Check and insert this tag separately.")</script>
                <?php endif;
            }
            elseif(strstr($key, "tt")!=FALSE)    {
                $q="INSERT INTO TopicTags SELECT ".$n.", TopicID ".
                    "FROM Topics WHERE TopicName LIKE '".$value."'";
        ?>
                <?php if(!mysqli_query($conn, $q)): ?>
                	<script>window.alert("Error occurred. "+
                        	"Check and insert this tag separately.")</script>
                <?php endif;
            }
        }
        ?>
        <script>window.alert("Inserted into the database successfully.");</script>
        <?php 
    }
}

mysqli_close($conn);
?>

	<form method="post" name="qform" onsubmit="return validateQForm()"
	action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Question</label>
		<div style="color:#AAA;">
			(For every single \, enter \\)
		</div>
		<textarea name="q" rows="6" placeholder="Enter your question"></textarea>
		
		<label>Option 1</label>
		<textarea name="o1" rows="2" placeholder="Option 1"></textarea>
		<label>Option 2</label>
		<textarea name="o2" rows="2"  placeholder="Option 2"></textarea>
		<label>Option 3</label>
		<textarea name="o3" rows="2"  placeholder="Option 3"></textarea>
		<label>Option 4</label>
		<textarea name="o4" rows="2"  placeholder="Option 4"></textarea>
		<label>Correct Answer</label>
		<select name="a" >
			<option>Option 1</option>
			<option>Option 2</option>
			<option>Option 3</option>
			<option>Option 4</option>
		</select>
		<!-- 
		<label>Image URL</label>
		<input name="u" type="url" placeholder="URL" /> 
		 -->
		
		<label>Language Tags</label>
		<div id="lt">
			<input name="lt1" type="text" placeholder="Tag" />
			<div class="Error">
			* Enter a valid tag containing only alphabets and numbers.
			</div>
		</div>
		<div class="button" onclick="addNewTag('lt')">+</div>
		
		<label>Topic Tags</label>
		<div id="tt">
    		<div style="color:#AAA;">
    			(Use one tag in each and each tag can contain spaces)
    		</div>
			<input name="tt1" type="text" placeholder="Tag" />
			<div class="Error">
			* Enter a valid tag containing only alphabets and numbers.
			</div>
		</div>
		<div class="button" onclick="addNewTag('tt')">+</div>
		
		<button type="submit" name="submit">Add</button>
	</form>
	
	<script src="../FormValidations.js"></script>
	<script src="OpenInFrame.js"></script>
	<script src="AddTags.js"></script>
	<script>
	function validateQForm()	{
		for(var i=1; i<=ltn; i++)	{
			var t=document.forms["qform"]["lt"+i];
			if(!validateTag(t))	return false;
		}
		for(var i=1; i<=ttn; i++)	{
			var t=document.forms["qform"]["tt"+i];
			if(!validateTag(t))	return false;
		}
		return true;
	}
	</script>
</body>
</html>