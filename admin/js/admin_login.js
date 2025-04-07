$(document).ready(function () {
    $('#submit').click(function (e) {
        e.preventDefault();

        const username = $('#username').val().trim();
        const email = $('#email').val().trim();
        const password = $('#password').val().trim();

        if (!username || !email || !password) {
            alert('Please fill in all fields.');
            return;
        }

        $.ajax({
            url: 'admin_login.php', 
            type: 'POST',
            data: {
                username: username,
                email: email,
                password: password
            },
            success: function (response) {
                if (response.trim() === 'success') {
                    alert('Login successful!');
                    window.location.href = 'admin/dashboard.php'; 
                } else {
                    alert('Login failed: ' + response);
                }
            },
            error: function () {
                alert('An error occurred while processing the request.');
            }
        });
    });
});
