$(document).ready(function () {
    StartToastMessage();
});

/*
* Event change handler on media type selected
*/
$('input[name=mediaType]').change(
    function () {
        var radioOption = $(this).val();

        if (radioOption == 'VideoURL') {
            $('#BrochureImage').uploadify('cancel');
            $('#BrochureImageRefer').val('');
            $('#showOptions').css('padding-top', '9px');
            $('#radios').css('padding-top', '9px');
            $("#optionsBlock").removeAttr("style");
            $('#brochureOption').hide();
            $('#videoOption').show();
            $('#urlVideo').val('');
            $('#urlVideo').focus();
        } else {
            $('#showOptions').css('padding-top', '9px');
            $('#optionsBlock').css('padding-top', '34px');
            $('#radios').css('padding-top', '9px');
            $('#brochureOption').show();
            $('#videoOption').hide();
        }
    }
);

/*
* Event change handler on media type selected
*/
$('input[name=mediaTypeModified]').change(
    function () {
        var radioOption = $(this).val();

        if (radioOption == 'VideoURL') {
            $('#BrochureImageModified').uploadify('cancel');
            $('#BrochureImageReferModified').val('');
            $('#showOptionsModified').css('padding-top', '2px');
            $('#brochureOptionModified').hide();
            $('#videoOptionModified').show();
            $('#urlVideoModified').focus();
        } else {
            $('#showOptionsModified').css('padding-top', '9px');
            $('#brochureOptionModified').show();
            $('#videoOptionModified').hide();
        }
    }
);

$('#showOptions').click(function () {
    if ($('#sizeOptions').is(':visible')) {
        $('#sizeOptions').hide();
        $('#showOptions').text('Show Options');
        if ($("input[name=mediaType]:checked").val() == 'Image') {
            $('#optionsBlock').css('padding-top', '34px');
        }
    } else {
        $('#sizeOptions').show();
        if ($("input[name=mediaType]:checked").val() == 'Image') {
            $('#optionsBlock').css('padding-top', '34px');
        }
        $('#showOptions').text('Hide Options');
    }
});

$('#showOptionsModified').click(function () {
    if ($('#sizeOptionsModified').is(':visible')) {
        $('#sizeOptionsModified').hide();
        $('#showOptionsModified').text('Show Options');
    } else {
        $('#sizeOptionsModified').show();
        $('#showOptionsModified').text('Hide Options');
    }
});