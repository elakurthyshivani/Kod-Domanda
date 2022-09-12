var fs=document.getElementById("features");
var f=document.getElementsByClassName("feature");
var m=document.getElementById("main");
var featureAnimationDone=false;

m.onscroll=function()	{
	if(fs.offsetTop<=m.scrollTop && !featureAnimationDone)	{
		featureAnimationDone=true;
		for(var i=1; i<=f.length; i++)	{
			f[i-1].style.visibility="visible";
			f[i-1].style.marginLeft=i*i+"%";
			f[i-1].style.width=100-i*i+"%";
		}
	}
}


var cur=0;
var s=document.getElementsByClassName("slide");
var c=document.getElementsByClassName("circle");

function toSlide(n, b)	{
	n=n+cur;
	if(n<0)	n=s.length-1;
	else if(n==s.length)	n=0;
	makeSlide(n, b);
}

function toSlideNumber(n)	{
	makeSlide(n, (n<cur?"prev":"next"));
}

function makeSlide(newcur, b)	{
	s[cur].style.display="none";
	s[cur].style.animation="";
	c[cur].className=c[cur].className.replace(" active", "");
	s[newcur].style.display="block";
	s[newcur].style.animation=(b=='prev'?"ltrshow":"rtlshow")+" 0.4s ease";
	c[newcur].className+=" active";
	cur=newcur;
}


function validateContact()	{
	var n=document.forms["contact"]["name"];
	var e=document.forms["contact"]["email"];
	var m=document.forms["contact"]["msg"];
	if(!validateName(n) || !validateEmail(e))
		return false;
	else if(m.value=="")	{
		m.nextElementSibling.style.display="block";
		return false;
	}
	m.nextElementSibling.style.display="none";
	return true;
}

function validateFeedback()	{
	var n=document.forms["feedback"]["name"];
	var m=document.forms["feedback"]["msg"];
	if(!validateName(n))	return false;
	else if(m.value=="")	{
		m.nextElementSibling.style.display="block";
		return false;
	}
	m.nextElementSibling.style.display="none";
	return true;
}