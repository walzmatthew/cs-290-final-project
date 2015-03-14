//create new user function
function create_user() {
	//get inputs from form
	var user = document.getElementById("username1").value;
	var pswd = document.getElementById("password1").value;
	
	//validate input provided for both fields
	if (!Boolean(user)) {//no username provided in form
		if (!Boolean(pswd)) {//no username and no password provided in form
			alert("A username and password are required to create an account.");
			return;
		} else {
			alert("A username is required to create an account.");
			return;
		}
	} else if (!Boolean(pswd)) {//no password provided in form
		alert("A password is required to create an account.");
		return;
	}
	
	//create AJAX call to check for existing username in database
	try { //For standard non IE browsers
		var addUser = new XMLHttpRequest();
	} catch(e) {
		try { //For IE 6+
			var addUser = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e1) { //if IE < 6 or some other unsupported browser
			alert("Your browser is not supported by this webpage. Please try using a newer browser.");
		}
	}
	
	var method = 'POST';
	var url = 'create_user.php';
	var params = 'username=' + user + '&password=' + pswd;
	
	addUser.open(method, url, true);
	addUser.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	addUser.send(params);
	
	addUser.onreadystatechange = function() {
		if (addUser.readyState === 4) {
			if (addUser.status === 200) { //AJAX returned normally
				if (addUser.responseText == '1062') { //duplicate username
					alert('Unfortunately, the username ' + user + ' already exists. Please choose a different one.');
					return;
				} else if (!(addUser.responseText == '')) { //some other error message
					alert(addUser.responseText);
					return;
				} else { //successfully created db entry. now redirect to content page
					alert('New account successfully created for ' + user);
					window.location = "http://web.engr.oregonstate.edu/~walzma/cs-290-final-project/content.php";
				}
			}

		}
	}
}



//create existing user sign-in function
function sign_in() {
	//get inputs from form
	var user = document.getElementById("username2").value;
	var pswd = document.getElementById("password2").value;
	
	//validate input provided for both fields
	if (!Boolean(user)) {//no username provided in form
		if (!Boolean(pswd)) {//no username and no password provided in form
			alert("A username and password are required to sign in.");
			return;
		} else {
			alert("A username is required to sign in.");
			return;
		}
	} else if (!Boolean(pswd)) {//no password provided in form
		alert("A password is required to sign in.");
		return;
	}
	
	//create AJAX call to check for existing username in database
	try { //For standard non IE browsers
		var sign_in = new XMLHttpRequest();
	} catch(e) {
		try { //For IE 6+
			var sign_in = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e1) { //if IE < 6 or some other unsupported browser
			alert("Your browser is not supported by this webpage. Please try using a newer browser.");
			return;
		}
	}
	
	var method = 'POST';
	var url = 'sign-in.php';
	var params = 'username=' + user + '&password=' + pswd;
	
	sign_in.open(method, url, true);
	sign_in.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	sign_in.send(params);
	
	sign_in.onreadystatechange = function() {
		if (sign_in.readyState === 4) {
			if (sign_in.status === 200) { //AJAX returned normally. check response
				if (sign_in.responseText == 'match') { //sign-in successful. redirect to content page
					window.location = "http://web.engr.oregonstate.edu/~walzma/cs-290-final-project/content.php";
				} else if (sign_in.responseText == 'username') { //username not found
					alert('The username ' + user + ' could not be found. Please try again.');
					return;
				} else if (sign_in.responseText == 'password') { //password did not match
					alert('The password entered was incorrect. Please try again.');
					return;
				} else { //unknown response from the server
					alert('Sign In was unsuccessful for unknown reason. Please try again.');
					return;
				}
			}

		}
	}
}

//add new to-do list item
function add_to_do() {
	//get inputs from form
	var title = document.getElementById("title").value;
	//verify title string length <= 30
	if (title.length > 60) {
		alert("Task Name field has a maximum input of 60 characters.");
		return;
	}	
	var description = document.getElementById("description").value;
	if (!Boolean(description)) { //if optional description not provided in form
		description = 'No description';
	}
	if (description.length > 100) {
		alert("Description field has a maximum input of 100 characters.");
		return;
	}
	//check if browser supports <input type="date" ... />. if not validate date string with algorithm
	var date = document.getElementById("due_date").value;
	if (checkDateInput()) { //true if browser supports <input type="date" ... />. Function from http://stackoverflow.com/questions/10193294/how-can-i-tell-if-a-browser-supports-input-type-date
		var dateString = date;
	} else { //browser does not support <input type="date" ... />. validate input string
		if (date.length == 10) { //correct length string input for date. Now check other conditions
			if (validateUSDate(date)) { //function from http://www.rgagnon.com/jsdetails/js-0063.html
				var dateString = date.substring(6, 10) + '-' + date.substring(0, 2) + '-' + date.substring(3, 5);
			} else { //not a valid date entry. day, month, or year entry not valid
				alert("Due Date must be a valid date and be entered in format 'mm/dd/yyyy'");
				return;
			}
		} else { //not a valid date entry. string length incorrect
			alert("Due Date must be entered in format 'mm/dd/yyyy'");
			return;
		}
	}
	
	var share = document.getElementById("share").value;
	
	//validate input provided for required fields (title and date)
	if (!Boolean(title)) {//no title provided in form
		if (!Boolean(date)) {//no title and no due date provided in form
			alert("A task name and valid due date are required to add a task to your To-Do List.");
			return;
		} else {
			alert("A task name is required to add a task to your To-Do List.");
			return;
		}
	} else if (!Boolean(date)) {//no due date provided in form
		alert("A valid due date is required to add a task to your To-Do List.");
		return;
	}
	
	//create AJAX call to add new task to to-do list database
	try { //For standard non IE browsers
		var newToDo = new XMLHttpRequest();
	} catch(e) {
		try { //For IE 6+
			var newToDo = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e1) { //if IE < 6 or some other unsupported browser
			alert("Your browser is not supported by this webpage. Please try using a newer browser.");
		}
	}
	
	var method = 'POST';
	var url = 'add_to_do.php';
	var params = 'title=' + title + '&description=' + description + '&date=' + dateString + '&share=' + share;
	
	newToDo.open(method, url, true);
	newToDo.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	newToDo.send(params);
	
	newToDo.onreadystatechange = function() {
		if (newToDo.readyState === 4) {
			if (newToDo.status === 200) { //AJAX returned normally
				document.getElementById("user_table").innerHTML = newToDo.responseText; //set "user_table" data equal to server response
			}
		} else { //while waiting. table displays loading image
			document.getElementById("user_table").innerHTML = '<img src="images/loading.gif">';
		}
	}
}

//delete to-do list item, id, function
function delete_to_do(id) {
	//create AJAX call to add new task to to-do list database
	try { //For standard non IE browsers
		var deleteToDo = new XMLHttpRequest();
	} catch(e) {
		try { //For IE 6+
			var deleteToDo = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e1) { //if IE < 6 or some other unsupported browser
			alert("Your browser is not supported by this webpage. Please try using a newer browser.");
		}
	}
	
	var method = 'POST';
	var url = 'delete_to_do.php';
	var params = 'id=' + id;
	
	deleteToDo.open(method, url, true);
	deleteToDo.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	deleteToDo.send(params);	
	
	deleteToDo.onreadystatechange = function() {
		if (deleteToDo.readyState === 4) {
			if (deleteToDo.status === 200) { //AJAX returned normally
				document.getElementById("user_table").innerHTML = deleteToDo.responseText; //set "user_table" data equal to server response
			}
		} else { //while waiting. table displays loading image
			document.getElementById("user_table").innerHTML = '<img src="images/loading.gif">';
		}
	}
}

//toggle sharing attribute of to-do list item, id, function
function toggle_share(id, share) {
	//create AJAX call to toggle sharing attribute of to-do list task in database
	try { //For standard non IE browsers
		var shareToDo = new XMLHttpRequest();
	} catch(e) {
		try { //For IE 6+
			var shareToDo = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e1) { //if IE < 6 or some other unsupported browser
			alert("Your browser is not supported by this webpage. Please try using a newer browser.");
		}
	}
	
	var method = 'POST';
	var url = 'toggle_share.php';
	var params = 'id=' + id + '&share=' + share;
	
	shareToDo.open(method, url, true);
	shareToDo.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	shareToDo.send(params);	
	
	shareToDo.onreadystatechange = function() {
		if (shareToDo.readyState === 4) {
			if (shareToDo.status === 200) { //AJAX returned normally
				document.getElementById("user_table").innerHTML = shareToDo.responseText; //set "user_table" data equal to server response
			}
		} else { //while waiting. table displays loading image
			document.getElementById("user_table").innerHTML = '<img src="images/loading.gif">';
		}
	}
}

//logout function
function logout() {
	//create AJAX call to php server to end session and redirect to login page
	try { //For standard non IE browsers
		var logout = new XMLHttpRequest();
	} catch(e) {
		try { //For IE 6+
			var logout = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e1) { //if IE < 6 or some other unsupported browser
			alert("Your browser is not supported by this webpage. Please try using a newer browser.");
		}
	}
	
	var method = 'POST';
	var url = 'logout.php';
	var params = 'logout=true';
	
	logout.open(method, url, true);
	logout.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	logout.send(params);	
	
	logout.onreadystatechange = function() {
		if (logout.readyState === 4) {
			if (!(logout.status === 200)) { //AJAX returned normally
				alert("AJAX logout call did not return normally.");
			}
		}
	}
}

function checkDateInput() {
/*****************************
function credit to http://stackoverflow.com/questions/10193294/how-can-i-tell-if-a-browser-supports-input-type-date

DESCRIPTION: checks if browser recognizes <input type="date" ... />. Returns true if recognized, false otherwise
*/
    var input = document.createElement('input');
    input.setAttribute('type','date');

    var notADateValue = 'not-a-date';
    input.setAttribute('value', notADateValue); 

    return !(input.value === notADateValue);
}

function validateUSDate( strValue ) {
/************************************************
Function credit to http://www.rgagnon.com/jsdetails/js-0063.html

DESCRIPTION: Validates that a string contains only
    valid dates with 2 digit month, 2 digit day,
    4 digit year. Date separator can be ., -, or /.
    Uses combination of regular expressions and
    string parsing to validate date.
    Ex. mm/dd/yyyy or mm-dd-yyyy or mm.dd.yyyy

PARAMETERS:
   strValue - String to be tested for validity

RETURNS:
   True if valid, otherwise false.

REMARKS:
   Avoids some of the limitations of the Date.parse()
   method such as the date separator character.
*************************************************/
  var objRegExp = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/
 
  //check to see if in correct format
  if(!objRegExp.test(strValue))
    return false; //doesn't match pattern, bad date
  else{
    var strSeparator = strValue.substring(2,3) 
    var arrayDate = strValue.split(strSeparator); 
    //create a lookup for months not equal to Feb.
    var arrayLookup = { '01' : 31,'03' : 31, 
                        '04' : 30,'05' : 31,
                        '06' : 30,'07' : 31,
                        '08' : 31,'09' : 30,
                        '10' : 31,'11' : 30,'12' : 31}
    var intDay = parseInt(arrayDate[1],10); 

    //check if month value and day value agree
    if(arrayLookup[arrayDate[0]] != null) {
      if(intDay <= arrayLookup[arrayDate[0]] && intDay != 0)
        return true; //found in lookup table, good date
    }
    
    //check for February (bugfix 20050322)
    //bugfix  for parseInt kevin
    //bugfix  biss year  O.Jp Voutat
    var intMonth = parseInt(arrayDate[0],10);
    if (intMonth == 2) { 
       var intYear = parseInt(arrayDate[2]);
       if (intDay > 0 && intDay < 29) {
           return true;
       }
       else if (intDay == 29) {
         if ((intYear % 4 == 0) && (intYear % 100 != 0) || 
             (intYear % 400 == 0)) {
              // year div by 4 and ((not div by 100) or div by 400) ->ok
             return true;
         }   
       }
    }
  }  
  return false; //any other values, bad date
}