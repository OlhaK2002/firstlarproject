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
                else {
                        $.each(result1.error, function (index, value) {
                            if (value === "The email has already been taken.") $('#error_email').append("Ваша почта уже используется другим пользователем");
                            else if (value === "The login has already been taken.") $('#error_login').append("Ваш логин уже используется другим пользователем");
                            else if (value === "The password1 must be at least 6 characters.") $('#error_password').append("Пароль должен быть не меньше шести символов");
                            else if (value === "The password2 and password1 must match.") $('#error_passwords').append("Пароли не совпадают");
                            else if (value === "The password1 format is invalid.") $('#error_password1').append("Пароль должен содержать цифры, а также символы верхнего и нижнего регистра");

                        });

                    $('#Password1').val('');
                    $('#Password2').val('');
                }
            },



        })
    })
})
