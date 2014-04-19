function showCompany(id) {
    $.ajax({
        type: "GET",
        url: "companies/retrieve",
        data: {
            id: id
        },
        success: function (msg) {
            var data = JSON.parse(msg);

            $('#CompanyId').val(id);
            $('#CompanyName').val(data[0].CompanyName);
            $('#URL').val(data[0].URL);
            $('#Username').val(data[0].Username);
            $('#Password').val(data[0].Password);
        },
        failure: function (msg) {
            toastr.error('Error :' + msg, "Message");
        }
    });

    $('#company-dialog').modal('show'); 
}

function saveCompany()
{
    if (!validateFields())
        return;
    
    var record = getFormData();

    if (!record.CompanyId)
        createCompany(record);
    else
        updateCompany(record);
}

function createCompany(record) {
    $.ajax({
        type: "GET",
        url: "companies/create",
        data: record,
        success: function (msg) {
            $('#company-dialog').modal('hide');
            window.location.href = 'companies';
        }
    });
}

function updateCompany(record) {
    $.ajax({
        type: "GET",
        url: "companies/update",
        data: record,
        success: function (msg) {
            $('#company-dialog').modal('hide');
            window.location.href = 'companies';
        }
    });
}

function deleteCompany(id) {
    $.ajax({
        type: "GET",
        url: "companies/delete",
        data: {
            id: id
        },
        success: function (msg) {
            window.location.href = 'companies';
        }
    });
}

function getFormData() {
    var record =
    {
        CompanyId: $('#CompanyId').val(),
        CompanyName: $('#CompanyName').val(),
        URL: $('#URL').val(),
        Username: $('#Username').val(),
        Password: $('#Password').val()
    };

    return record;
}

function validateFields()
{
    if (!validateField('CompanyName', 'Please enter a company name.'))
        return false;

    if (!validateField('URL', 'Please enter an url.') || !validateURLField('URL', 'Please enter a valid url.'))
        return false;

    if (!validateField('Username', 'Please enter an username.'))
        return false;

    if (!validateField('Password', 'Please enter a password.'))
        return false;

    return true;
}