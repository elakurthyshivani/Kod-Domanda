showPBox();
setColors();

function showPBox()	{
	var b=document.getElementById("b-con");
	b.style.filter="blur(5px)";
}

function showBBox(n)	{
	var p1=document.getElementsByTagName("input")[0], p2;
	if(n==0)	p2=document.getElementsByTagName("input")[1];
	
	if(checkBeforeProceed(n, p1, p2))	{		
		var x=new XMLHttpRequest();
		x.onreadystatechange=function()	{
			if(this.readyState==4 && this.status==200)	{
				var r=this.responseText;
				if(r==1)	{
					p1.nextElementSibling.style.display="none";
					
					var b=document.getElementById("b-con");
					b.style.filter="blur(0px)";
					b.style.zIndex="0";
					var p=document.getElementById("p-con");
					p.style.zIndex="-1";
					p.style.display="none";
				}
				else	{
					p1.nextElementSibling.style.display="block";
					p1.nextElementSibling.innerHTML="* Wrong password. Please try again..";
				}
			}
		};
		x.open("POST", "ValidatePassword.php", true);
		x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		x.send("n="+n+"&p="+p1.value);
	}
}

function checkBeforeProceed(n, p1, p2)	{	
	var b1=validatePassword(p1), b2;
	if(n==0)	b2=validatePassword(p2);
	
	if((n==1 && b1) || (n==0 && b1 && b2 && p1.value==p2.value))	{
		p1.nextElementSibling.style.display="none";
		if(n==0)	p2.nextElementSibling.style.display="none";
		return true;
	}
	else if(n==0)	{
		if(!b1)	{
			p1.nextElementSibling.style.display="block";
			p2.nextElementSibling.style.display="none";
			p1.nextElementSibling.innerHTML="* A valid password consists of "+
			"alphanumeric characters and ._!@#$%^&amp;* special characters.";
		}
		else if(!b2)	{
			p2.nextElementSibling.style.display="block";
			p1.nextElementSibling.style.display="none";
			p2.nextElementSibling.innerHTML="* A valid password consists of "+
			"alphanumeric characters and ._!@#$%^&amp;* special characters.";
		}
		else	{
			p1.nextElementSibling.style.display="block";
			p2.nextElementSibling.style.display="none";
			p1.nextElementSibling.innerHTML="Password doesn't match.";
		}
	}
	else	{
		p1.nextElementSibling.style.display="block";
		p1.nextElementSibling.innerHTML="* Wrong password. Please try again..";
	}
	return false;
}

function makeActive(x)	{
	var a=document.getElementsByTagName("a");
	for(var i=0; i<a.length; i++)
		a[i].className="";
	a[x-1].className="active";
}

function setColors()	{
	var a=document.getElementsByTagName("a");
	var h=0xff1493, l=0xff0000, d=Math.floor((h-l)/8);
	for(var i=0; i<a.length; i++)
		a[i].style.backgroundColor="#FF0A"+(i+4)+"0";
}