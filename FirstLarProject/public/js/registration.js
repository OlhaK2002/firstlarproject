$(document).ready(function () {
    $('#registration').click(function (event) {
        event.preventDefault();
        var Name = $('#Name').val();
        var Surname = $('#Surname').val();
        var Email = $('#Email').val();
        var Login = $('#Login').val();
        var Password1 = $('#Password1').val();
        var Password2 = $('#Password2').val();
        $('#error_email').empty();
        $('#error_login').empty();
        $('#error_password').empty();
        $('#error_password1').empty();
        $('#error_passwords').empty();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/registration/register',
            type: 'POST',
            dataType: 'json',
            data: {
                Name: Name,
                Surname: Surname,
                Email: Email,
                Login: Login,
                Password1: Password1,
                Password2: Password2
            },
            success: function (result1) {
                console.log(result1);
                if (result1['success'] === "success") {
                    window.location.href = "/";
                }
            },
            error: function (result2)
            {

                let result = result2.responseJSON.errors;
                $.each(result, function (index, value) {
                    if(index === 'Email') $('#error_email').append(value);
                    else if(index === 'Login') $('#error_login').append(value);
                    else if(index === 'Password2') $('#error_passwords').append(value);
                    else {
                        $.each(value, function (id, value2){
                            if(value2 === "Пароль должен содержать цифры, а также символы верхнего и нижнего регистра")$('#error_password1').append(value2);
                            else if (value2 === "Пароль должен быть не меньше шести символов")$('#error_password').append(value2);

                        })
                    }
                });
            }
        })
    })
})
