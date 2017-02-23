function makeAlert()
{
	var list = document.form_name.emp_type;
	var emp_type = list.options[list.selectedIndex].text;
	if(emp_type=="Driver")
	{
		 // driver validations
		document.getElementById("dname").innerHTML="Driver Name: ";
		document.getElementById("dmob").innerHTML="Driver Mobile No.: ";
	}
	else
	{
		// employee validations
		document.getElementById("dname").innerHTML="Employee Name: ";
		document.getElementById("dmob").innerHTML="Employee Mobile No.: ";
	}
}


function dovalidation()
{
	
	var list = document.form_name.emp_type;
	var emp_type = list.options[list.selectedIndex].text;
	if(emp_type=="Driver")
	{
		if(document.form_name.driver_name.value=="")
		{
			alert("plz Enter Driver Name");
			return false;
		}
		if(document.form_name.driver_mobile_number.value=="")
		{
			alert("plz Enter Driver Mobile Number");
			return false;
		}
		if(document.form_name.father_name.value=="")
		{
			alert("plz Enter Father Name");
			return false;
		}
		if(document.form_name.driver_dob.value=="")
		{
			alert("plz Enter Date of Birth");
			return false;
		}
		if(document.form_name.driver_doj.value=="")
		{
			alert("plz Enter Date of Joining");
			return false;
		}
		if(document.form_name.driver_licence_number.value=="")
		{
			alert("plz Enter Driver Licence Number");
			return false;
		}
		if(document.form_name.driver_licence_issue_date.value=="")
		{
			alert("plz Enter Licence Issue Date");
			return false;
		}
		if(document.form_name.driver_licence_issue_place.value=="")
		{
			alert("plz Enter Issue Place");
			return false;
		}
		if(document.form_name.driver_licence_valid_date.value=="")
		{
			alert("plz Enter Licence Expiry Date");
			return false;
		}
		return true;
	}
	else
	{
		if(document.form_name.driver_name.value=="")
		{
			alert("plz Enter Employee Name");
			return false;
		}
		if(document.form_name.driver_mobile_number.value=="")
		{
			alert("plz Enter Employee Mobile Number");
			return false;
		}
		if(document.form_name.driver_qualification.value=="")
		{
			alert("plz Enter Qualification");
			return false;
		}
		if(document.form_name.driver_per_address.value=="")
		{
			alert("plz Enter Address");
			return false;
		}
		if(document.form_name.driver_doj.value=="")
		{
			alert("plz Enter Date of Joining");
			return false;
		}
		if(document.form_name.driver_dob.value=="")
		{
			alert("plz Enter Date of Birth");
			return false;
		}
		if(document.form_name.father_name.value=="")
		{
			alert("plz Enter Father Name");
			return false;
		}
		return true;
	}
	
}