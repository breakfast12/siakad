const bearerKey = "BREAR_KEY";

function login() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: "/login",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN':`${token}`,
            'Accept':'application/json'
        },
        dataType: "json",
        data: {
            "email": email,
            "password": password
        },
        success:function(data) {
            if(data.success){
                
                location.replace("/dashboard");
                document.cookie = 'bearerToken = ' + data.data.token;
            }

            console.log(data.data.token);
        },
        error:function (xhr, ajaxOptions, thrownError){
            if(xhr.status==404) {
                alert('Email atau Password Salah');
                // var err = eval("(" + xhr.responseText + ")");
                // console.log(err);

            }
        }
    });
}