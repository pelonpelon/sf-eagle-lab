function StartCountDown(myDiv,myTargetDate)
{
	var dthen	= new Date(myTargetDate);
	var dnow	= new Date();
	ddiff		= new Date(dthen-dnow);
	msecs		= Math.floor(ddiff.valueOf());
	CountBack(myDiv,msecs);
}

function Calcage(msecs, num1, num2)
{
	s = ((Math.floor(msecs/num1))%num2).toString();
	if (s.length < 2) 
	{	
		s = "0" + s;
	}
	if ((num1 == 1) && (s.length < 3))
	{	
		s = "0" + s;
	}
	return (s);
}

function CountBack(myDiv, msecs)
{
	var DisplayStr;
	var DisplayFormat = "%%H%%:%%M%%:%%S%%:%%N%%";
	// var DisplayFormat = "%%D%% Days<br /> %%H%%:%%M%%:%%S%%:%%N%%";
	// DisplayStr = DisplayFormat.replace(/%%D%%/g,	Calcage(msecs,86400000,1000));
	DisplayStr = DisplayFormat.replace(/%%H%%/g,		Calcage(msecs,3600000,24));
	DisplayStr = DisplayStr.replace(/%%M%%/g,		Calcage(msecs,60000,60));
	DisplayStr = DisplayStr.replace(/%%S%%/g,		Calcage(msecs,1000,60));
	DisplayStr = DisplayStr.replace(/%%N%%/g,		Calcage(msecs,1,1000));
	if(msecs > 0)
	{	
		document.getElementById(myDiv).innerHTML = DisplayStr;
		setTimeout("CountBack('" + myDiv + "'," + (msecs-11) + ");", 9.80);
	}
	else
	{
		document.getElementById(myDiv).innerHTML = "HAPPY BIRTHDAY SF-EAGLE !!!";
	}
}

