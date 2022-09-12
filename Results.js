var c=0;
var card=document.getElementsByClassName("card");
showCard(c, "");

function changeCard(n)	{
	n+=c;
	if(n<0)	n=card.length-1;
	else if(n>=card.length)	n=0;
	showCard(n, (n<c?"prev":"next"));
}

function showCard(n, b)	{
	var prev=document.getElementById("prev");
	var next=document.getElementById("next");
	var fini=document.getElementById("fini");
	
	card[c].style.display="none";
	card[c].style.animation="";
	card[n].style.display=(n==0?"flex":"block");
	card[n].style.animation=(b=='prev'?"ltrshow 0.4s ease":"rtlshow 0.6s ease");
	c=n;
	
	if(c==0)	prev.style.display="none";
	else	prev.style.display="block";

	if(c==card.length-1)	{
		next.style.display="none";
		fini.style.display="block";
	}
	else	{
		next.style.display="block";
		fini.style.display="none";
	}
}