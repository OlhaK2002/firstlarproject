$(document).ready(function () {
    $('#authorization').click(function (event) {
        event.preventDefault();
        let login1 = $('#login1').val();
        let password2 = $('#password2').val();
        $('#result').empty();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/authorization/login',
            type: 'post',
            dataType: 'json',
            data: {login1: login1, password2: password2},
            success: function (result) {
                console.log(result['error_login']);
                if(result['error_login'] === "")
                {
                    window.location.href = "/";
                }
                else
                {
                    $('#result').append(result['error_login']);
                }
                $('#password2').val('');

            }

        })
    })
})

