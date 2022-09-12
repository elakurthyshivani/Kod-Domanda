window.onload=function()	{
	var b=inIFrame();
	if(!b)	window.location="Start.php";
}

function inIFrame()	{
    try {	return window.self !== window.top;	}
    catch (e) {	return true;	}
}