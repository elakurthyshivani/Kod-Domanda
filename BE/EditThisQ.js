expand();

function expand()	{
	var t=document.getElementsByTagName("textarea");
	for(var i=0; i<t.length; i++)
		t[i].style.height=t[i].scrollHeight+5+"px";
}