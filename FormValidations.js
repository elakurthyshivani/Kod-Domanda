function validateName(n)	{
	if(!/^[A-z0-9._ ]{1,60}$/.test(n.value))	{
		n.nextElementSibling.style.display="block";
		return false;
	}
	n.nextElementSibling.style.display="none";
	return true;
}

function validateEmail(e)	{
	if(!/^[A-z0-9_]{5,60}@[A-z]{2,20}\.[A-z0-9]{1,5}$/.test(e.value))	{
		e.nextElementSibling.style.display="block";
		return false;
	}
	e.nextElementSibling.style.display="none";
	return true;
}

function validateURL(u)	{
	if(!/^([A-z0-9 -]{1,20}\/)+[A-z0-9 -]{1,60}\.[A-z]{2,5}$/.test(u.value))	{
		u.nextElementSibling.style.display="block";
		return false;
	}
	u.nextElementSibling.style.display="none";
	return true;
}

function validateTag(t)	{
	if(!/^[A-z _]{1,60}$/.test(t.value))	{
		t.nextElementSibling.style.display="block";
		return false;
	}
	t.nextElementSibling.style.display="none";
	return true;
}

function validatePassword(p)	{
	if(!/^[A-z0-9._!@#$%^&*]{8,60}$/.test(p))	{
		window.alert("Invalid password.");
		return false;
	}
	return true;
}