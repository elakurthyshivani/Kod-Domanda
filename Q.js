cur=0;
ans=[-1, -1, -1, -1, -1, -1, -1, -1, -1, -1];

displayQ(cur);

function pnQ(x, n)	{
	x+=cur;
	if(x<0)	x=n-1;
	else if(x>=n)	x=0;
	displayQ(x);
}

function displayQ(n)	{
	var qn=document.getElementsByClassName('qn');
	var q=document.getElementsByClassName('q');
	var t=document.getElementsByClassName('tag');
	var a=document.getElementsByClassName('a');
	cur=n;
	for(i=0; i<qn.length; i++)	{
		qn[i].className=qn[i].className.replace(" cur", "");
		q[i].style.display='none';
		t[i].style.display='none';
		a[i].style.display='none';
		
	}
	qn[cur].className+=" cur";
	q[cur].style.display='block';
	t[cur].style.display='block';
	a[cur].style.display='block';
}

function selectOption(i, j)	{
	var a=document.getElementsByClassName("a")[i];
	var oc=document.getElementsByClassName("o-con"+(i+1));
	var o=document.getElementsByName("o"+(i+1));
	for(k=0; k<oc.length; k++)	{
		oc[k].style.backgroundColor='White';
		o[k].checked='false';
	}
	oc[j].style.backgroundColor='#EFEFEF';
	o[j].checked="true";
	
	var q=document.getElementsByClassName('qn')[i].children;
	q=q[0].children;
	q[0].style.color='green';
	ans[i]=j;/*i:0-9, j:0-3*/
}

function showTips()		{
	document.getElementById("tip-con").style.display="block";
}

function closeTips()	{
	document.getElementById("tip-con").style.display="none";
}

function endQuiz()	{
	var a=document.forms["eq"]["ans"];
	var q=document.forms["eq"]["ques"];
	a.value=ans;
	q.value=ques;
	return true;
}