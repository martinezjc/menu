/**
 * @author gbritton
 */
function getBaseURL(find) 
{
    var location = window.location.href;

    if (find != null && find != '')
        return location.substring(0, location.indexOf(find) + find.length);
    else
        return 'http://menuapp.com';
}

/**
 * @deprecated use getFloat instead.
 */
function GetFloat(value) {
    return getFloat(value);
}

/**
 * @param value: Amount with or without currency format or a simple number value.
 *
 * @returns float
 */
function getFloat(value)
{
    if ((typeof value == 'string' || value instanceof String) && value != '')
        value = value.toString().replace('$', '').replace(',', '');
    else
        if (value == null || isNaN(value))
            value = 0;

    return parseFloat(value);
}

/**
 * @param value: A text or number that is supposed to be an integer.
 * 
 * @returns int
 */
function getInt(value)
{
    if (value == null || value == '')
        value = 0;

    // TODO: Verify if this produce a NaN
    return parseInt(value);
}

/**
 * @param id: HTML element id which will display the value as an amount with currency format
 * @param value: The numeric value that will be converted to an amount with currency format
 *
 * @returns void
 */
function setAmount(id, value)
{
    $(id).text(getAmount(value));
}

/**
 * @param value: A text or number that should be interpreted as an amount with currencty format
 *
 * @returns: string
 */
function getAmount(value)
{
    return '$' + getFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}

function getBitFromCheckBox(id)
{
    return $(id).prop("checked") ? 1 : 0;
}

function validateURL(textval) {
    var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");

    return urlregex.test(textval);
}

function removeHtmlElement(element, selector) 
{
    var row = element.closest(selector)[0];

    row.parentNode.removeChild(row);
}

function validateField(id, message) 
{
    var field = $('#' + id);

    if (field.val())
        return true;
    else
        showErrorMessage(field, message);
        return false;
}

function validateURLField(id, message) 
{
    var field = $('#' + id);

    if (!validateURL(field.val())) 
    {
        showErrorMessage(field, message);
        return false;
    } else {
        return true;
    }
}

function showErrorMessage(field, message) 
{
    field.focus();
    toastr.error(message, "Message");
}

function showSuccessMessage(message, action, url) 
{
    toastr.success(message, "Message");

    switch(action) 
    {
        case 'redirect': window.location.href = url; break;
    }  
}

/* General AJAX Builder */
function ajaxBuilder(url, parameters, callback_function)
{
    $.ajax({
        type: "GET",
        url: url,
        data: parameters,
        success: callback_function,
        failure: function (msg) {
            showErrorMessage(null, msg);
        }
    });
}