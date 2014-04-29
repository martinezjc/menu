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
    
    if ($('#UserId').val() == '') 
    {
        ajaxBuilder(currentUrl + '/accounts/create', parameters, function(insertUserData){
            if (insertUserData == 'true') 
            {
                $('#userModal').modal('hide');
                showSuccessMessage('The user account has been created.');
                location.reload();
            }
        });

    } else {
        
        ajaxBuilder(currentUrl + '/accounts/update', parameters, function(updateUserData){
            if (updateUserData == 'true') 
            {
                $('#userModal').modal('hide');
                showSuccessMessage('The user account has been updated.');
                location.reload();
            }
        });

    }
});

function deleteUser(userId) 
{
    var parameters = {
        id : userId
    };

    ajaxBuilder(currentUrl + "/accounts/delete", parameters, function(deleteUserData){
        if (deleteUserData == 'true')
        {
            showSuccessMessage('The user account has been removed.');
            location.reload();
        }
    });
}

function showUser(userId)
{
    $('#userModal').modal('show');

    var parameters = { jsonFormat: true,
                       id: userId 
                     };

    ajaxBuilder(currentUrl + '/accounts/retrieve', parameters, function(retrieveUserData){ 
        var data = JSON.parse(retrieveUserData);

        $('#FirstName').val(data[0].FirstName);
        $('#Username').val(data[0].Username);
        $('#Password').val(data[0].Password);
        $('#Password').val(data[0].Password);
        $('#LastName').val(data[0].LastName);
        $('#Email').val(data[0].Email);
        $('#UserId').val(data[0].UserId);
        
        if (data[0].DealerId) {
          $('#DealerId').val(data[0].DealerId);
        }

        if (data[0].Administrator == 1) {
            $("#isAdministrator").prop("checked", true);
        } else {
            $("#isAdministrator").prop("checked", false);
        }
    });
} 