function setColors(a, opacity)	{
	var x, y, z, i;
	for(i=0; i<a.length; i++)	{
		x=Math.floor(Math.random()*256);
		y=Math.floor(Math.random()*256);
		z=Math.floor(Math.random()*256);
		a[i].style.backgroundColor="rgba("+x+", "+y+", "+z+", "+opacity+")";
	}
}