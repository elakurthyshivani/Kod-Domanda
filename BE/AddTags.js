var ltn=1, ttn=1;

function addNewTag(x)	{
	var t=document.getElementById(x);
	var i=document.createElement("input");
	i.name=x+(x=='lt'?(++ltn):(++ttn));
	i.type="text";
	i.placeholder="Tag";
	t.appendChild(i);

	var d=document.createElement("div");
	d.className="Error";
	d.innerHTML="* Enter a valid tag containing only alphabets and numbers.";
	t.appendChild(d);
}