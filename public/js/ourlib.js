var shownDiv = "";
function showDiv(divid)
{
	if (shownDiv != "")
		document.getElementById(shownDiv).style.display = "none";

	document.getElementById(divid).style.display = "block";
	shownDiv = divid;
}
