$(function () {
    $(".form-validate").validate({
        errorPlacement: function(error, element)
        {
            error.insertAfter(element);
        }
    });



});