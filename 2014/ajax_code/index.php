<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Insert title here</title>
<script type="text/javascript">

function myfun()
{
	//var age = document.getElementById('mydate');
	var list = document.forms[0].mydate;
	var final_val = list.options[list.selectedIndex].text;
	alert(final_val);
}
function ajaxFunction(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.myForm.my.value = ajaxRequest.responseText;
		}
	}
	var list = document.forms[0].mydate;
	var final_val = list.options[list.selectedIndex].text;
	ajaxRequest.open("GET", "get_teriff_rate.php?mydate=" + final_val, true);
	ajaxRequest.send(null); 
}

</script>
</head>
<body>
<form name='myForm'>
Max Age: <input type='text' id='age' /> <br />
<select id="mydate" name="mydate">
<option value="1">1</option>
<option value="2">2</option>
</select>
Max WPM: <input type='text' id='wpm' name='my' id='my' onmousedown="ajaxFunction()"/>
<br />
</form>
</body>
</html>