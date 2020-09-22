$(document).ready(function () {
    $('#authorization').click(function () {
        let login1 = $('#login1').val();
        let password2 = $('#password2').val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $('#result').empty();
        console.log(login1, password2)

        $.ajax({
            url: '/authorization',
            type: 'POST',
            dataType: 'html',
            data: {login1: login1, password2: password2,  _token: _token},
            success: function (result) {
                console.log(result);
            }

        })
    })
})
