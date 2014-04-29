var globalUserId;

$('#saveUserData').click( function() {
    var isAdministrator;
    var PasswordValueChange;

    if ( $('#Username').val() == '' || $('#Password').val() == '' || $('#FirstName').val() == '' ) 
    {
        toastr.error('Please fill the form.', "Attention!");
        $('#FirstName').focus();
        return false;
    }

    if ( $("#isAdministrator").prop("checked") ) 
    {
        isAdministrator = true;
    } else {
        isAdministrator = false;
    }

    if ( $('#Password').val() == $('#PasswordRemember').val() ){
        PasswordValueChange = '0';
    } else {
        PasswordValueChange = '1';
    }

    var pathname = $(location).attr('href');
    var parameters = { UserId: $('#UserId').val(),
                       FirstName: $('#FirstName').val(),
                       LastName: $('#LastName').val(),
                       Email: $('#Email').val(),
                       Username: $('#Username').val(),
                       Password: $('#Password').val(),
                       DealerId: $('#DealerId').val(),
                       Administrator: isAdministrator,
                       PasswordChange: PasswordValueChange };    
    
    if ($('UserId').val() == '') 
    {
        ajaxBuilder('insertUser', parameters, function(insertUserData){
            if (insertUserData == 1) 
            {
                showSuccessMessage('The user account has been created', 'redirect', pathname);
            }
        });

    } else {
        
        ajaxBuilder('updateUser', parameters, function(updateUserData){
            if (updateUserData == 1) 
            {
                $('#userModal').modal('hide');
                showSuccessMessage('The user account has been updated', 'redirect', pathname);
            }
        });

    }
});

$('#insertUser').click( function() {
	var isAdministrator;
    var pathname = $(location).attr('href');

	if ( $('#Username').val() == '' || $('#Password').val() == '' || $('#FirstName').val() == '' ) {
		toastr.error('Please fill the form.', "Attention!");
		$('#FirstName').focus();
		return false;
	}

	if ( $("#isAdministrator").prop("checked") ) {
        isAdministrator = true;
	} else {
		isAdministrator = false;
	}
     

    $.ajax({
        type: "GET",
        url: "insertUser",
        data: {
            FirstName: $('#FirstName').val(),
            LastName: $('#LastName').val(),
            Email: $('#Email').val(),
            Username: $('#Username').val(),
            Password: $('#Password').val(),
            DealerId: $('#DealerId').val(),
            Administrator: isAdministrator
        },
        success: function (msg) {
            $('#userModal').modal('hide');
            window.location.href = pathname;
        },
        failure: function (msg) {
            toastr.error(msg + '.', "Attention!");
        }
    });
});

function editUser(UserId)
{
    var parameters = { UserId: UserId };
    ajaxBuilder('getUserData', parameters, function(bindUserData){
        userResponse = JSON.parse(bindUserData);
        
        $('#UserId').val(userResponse[0].UserId);
        $('#FirstName').val(userResponse[0].FirstName);
        $('#Username').val(userResponse[0].Username);
        $('#Password').val(userResponse[0].Password);
        $('#PasswordRemember').val(userResponse[0].Password);
        $('#LastName').val(userResponse[0].LastName);
        $('#Email').val(userResponse[0].Email);

        if (userResponse[0].DealerId) 
        {
            $('#DealerId').val(userResponse[0].DealerId);
        }

        if (userResponse[0].Administrator == 1) 
        {
            $("#isAdministrator").prop("checked", true);
        } else {
            $("#isAdministrator").prop("checked", false);
        }

    });
}

$('#userModal').on('show.bs.modal', function () {
	clearUserForm();
});

function clearUserForm(){
	$('#FirstName').val('');
    $('#Username').val('');
    $('#Password').val('');
    $('#LastName').val('');
    $('#Email').val('');
    $('#DealerId option').eq(1).prop('selected', true);
    $("#isAdministrator").prop("checked", false);
    $('#FirstName').focus();
}

$("body").on("click", "a", function (event) {
    globalUserId = $(this).attr('name');
});

$('#userUpdateModal').on('show.bs.modal', function () {
$.ajax({
        type: "GET",
        url: "infoUser",
        data: {
            jsonFormat: true,
            UserId: globalUserId
        },
        success: function (msg) {
            var data = JSON.parse(msg);
            
            $('#FirstName').val(data[0].FirstName);
            $('#Username').val(data[0].Username);
            $('#Password').val(data[0].Password);
            $('#Password').val(data[0].Password);
            $('#LastName').val(data[0].LastName);
            $('#Email').val(data[0].Email);
            
            if (data[0].DealerId) {
              $('#DealerIdHidden').val(data[0].DealerId);
            }

            if (data[0].Administrator == 1) {
            	$("#isAdministratorModified").prop("checked", true);
            } else {
            	$("#isAdministratorModified").prop("checked", false);
            }

        },
        failure: function (msg) {

        }
    });
});

$('#updateUser').click( function() {
var isAdministrator;
var PasswordValueChange;

if ( $('#PasswordModified').val() == $('#PasswordRemember').val() ){
	PasswordValueChange = '0';
} else {
	PasswordValueChange = '1';
}

if ( $("#isAdministratorModified").prop("checked") ) {
   isAdministrator = true;
} else {
	isAdministrator = false;
}

if (!globalUserId || globalUserId == '') {
    globalUserId = $('#UserId').val();
}

var pathname = $(location).attr('href');
$.ajax({
        type: "GET",
        url: "updateUser",
        data: {
        	UserId: globalUserId,
            FirstName: $('#FirstNameModified').val(),
            Username: $('#UsernameModified').val(),
            Password: $('#PasswordModified').val(),
            DealerId: $('#DealerIdModified').val(),
            LastName: $('#LastNameModified').val(),
            Email: $('#EmailModified').val(),
            Administrator: isAdministrator,
            PasswordChange: PasswordValueChange
        },
        success: function (msg) {
            window.location.href = pathname;
        },
        failure: function (msg) {
        	toastr.error(msg + '.', "Attention!");
        }
    });
});

$('#updateAdminAccount').click( function() {
var isAdministrator;
var PasswordValueChange;

if ( $('#PasswordModified2').val() == $('#PasswordRemember2').val() ){
    PasswordValueChange = '0';
} else {
    PasswordValueChange = '1';
}

if ( $("#isAdministratorModified2").prop("checked") ) {
   isAdministrator = true;
} else {
    isAdministrator = false;
}

if (!globalUserId || globalUserId == '') {
    globalUserId = $('#UserId2').val();
}

var pathname = $(location).attr('href');
$.ajax({
        type: "GET",
        url: "updateUser",
        data: {
            UserId: globalUserId,
            FirstName: $('#FirstNameModified2').val(),
            Username: $('#UsernameModified2').val(),
            Password: $('#PasswordModified2').val(),
            DealerId: $('#DealerIdModified2').val(),
            LastName: $('#LastNameModified2').val(),
            Email: $('#EmailModified2').val(),
            Administrator: isAdministrator,
            PasswordChange: PasswordValueChange
        },
        success: function (msg) {
            toastr.success('The account has been updated.', 'success');
            setTimeout(function(){
              window.location.href = 'dealer-settings';
            }, 2000);
        },
        failure: function (msg) {
            toastr.error(msg + '.', "Attention!");
        }
    });
});

function deleteUser(id) {
    var pathname = $(location).attr('href');
    $.ajax({
        type: "GET",
        url: "deleteUser",
        data: {
            UserId: id
        },
        success: function (msg) {
            window.location.href = pathname;
        },
        failure: function (msg) {
        }
    });
}

$('#Password').keyup(function (e) {
    if (e.keyCode == 13) {
        //$("#circleG").show();
        $('#circleG_1').show();
        $('#circleG_2').show();
        $('#circleG_3').show();
        if ($("#remeberme").prop("checked")) {
            authenticate(1);
        } else{
            authenticate(0);
        };
        return false;
    }
});

$('#loginPlan').click(function () {
    //$("#circleG").show();
    $('#circleG_1').show();
    $('#circleG_2').show();
    $('#circleG_3').show();
    if ($("#remeberme").prop("checked")) {
        authenticate(1);
    } else{
        authenticate(0);
    };
});

function authenticate(remeberme) {
    $.ajax({
        type: "GET",
        url: "authenticate",
        data: {
            Username: $('#Username').val(),
            Password: $('#Password').val(),
            Remeberme: remeberme
        },
        success: function (msg) {        
            if (msg == '0') {
               document.getElementById('message').style.display = 'block';
                $('#message').html('<i class="fa fa-exclamation-triangle"></i> Wrong Username or Password');
            } else {
                var data = JSON.parse(msg);
                window.location.href = 'home';//data[0].LastURL;
            }
        },
        failure: function (msg) {
            //$("#circleG").hide();
            $('#circleG_1').hide();
            $('#circleG_2').hide();
            $('#circleG_3').hide();
            toastr.error('User not found.', "Message");

        }
    }).always(function() {
      //$("#circleG").hide();
      $('#circleG_1').hide();
      $('#circleG_2').hide();
      $('#circleG_3').hide();
    });
}

$('#resetPassword').click( function(){
    var email=$('#Email').val();
    if(email!==''){
        $.ajax({
            type: "GET",
            url: "sendMailPassword",
            data: {
                Email: email
            },
            success: function (msg) {
                var response=JSON.parse(msg);
                if(response.Found)
                {
                    toastr.success(response.Message + '.');
                    $('#resetPasswordModal').modal('hide');
                }
                else{
                    $('#errorMessage').html(response.Message+ '.');
                }
            },
            failure: function (msg) {
            }
        });
    }
    else
       $('#errorMessage').html('Please enter an Email address.'); 
});

$('#Email').keypress(function(){
    $('#errorMessage').html('');
});

$('#resetPasswordModal').on('hidden.bs.modal',function(){
    $('#Email').val('');
    $('#errorMessage').html('');
});

$('#changePassword').click(function(){
    var passwordNew=$('#passwordNew').val();
    var passwordConfirm=$('#passwordConfirm').val();
    if(passwordNew===''||passwordConfirm===''){
        $('#errorMessage').html('Please fill both password fields.'); 
    }
    else if(passwordNew===passwordConfirm)
    {
        $('#errorMessage').html("");
        $.ajax({
            type: "GET",
            url: "savePassword",
            data: {
                UserId:getUrlVars()["UserId"],
                newPassword: passwordNew
            },
            success: function (msg) {
                if(msg==1){
                    toastr.success('Your password has been changed successfully!');
                    setTimeout('window.location.href = "login"',2000);
                }
                else
                    toastr.error('An error occurred, please try again.');
            },
            failure: function (msg) {
            }
        }); 
    }
    else
        $('#errorMessage').html("Passwords doesn't match"); 
});

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
};

$('#passwordNew, #passwordConfirm').keypress(function(){
    $('#errorMessage').html('');
});
