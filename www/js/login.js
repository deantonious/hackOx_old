
document.getElementById('btn-login').addEventListener('click', function () {
    login(document.getElementById('username').value, document.getElementById('password').value);
});

document.getElementById('login-form').addEventListener('keyup', function (event) {
    if (event.keyCode == 13) {
        login(document.getElementById('username').value, document.getElementById('password').value);
    }
});

function login(user, pass) {
    var params = {
        'username' : user,
        'password' : pass
    };
    fetch('core/login.ajax.php', {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }).then(function (response) {
        return response.text();
    }).then(function (output) {
        if (output == 'false') {
            Materialize.toast('Wrong login details!', 3000, 'red darken-4');
            document.getElementById('username').className = 'validate invalid';
            document.getElementById('password').className = 'validate invalid';
        } else {
            location.reload();
        }
    });
}
