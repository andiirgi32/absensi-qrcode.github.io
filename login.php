<?php
include "admin/koneksi.php";
session_start();
if (isset($_SESSION['userid'])) {
    header("Location:admin/index.php");
} else if (!isset($_SESSION['kodeakses'])) {
    header("Location:login_akses.php");
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="admin/js/color-modes.js"></script>
    <meta charset="utf-8">
    <title>Login - Selamat Datang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="admin/css/style.css">

    <link rel="stylesheet" href="admin/css/bootstrap.css">
    <link rel="icon" href="admin/logo/smkn_labuang.png">

    <style>
        @media (max-width: 767px) {
            .wrapper {
                background-image: url('admin/default/image-5.png');
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
        }
    </style>
</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>

    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>

    <div class="wrapper container-fluid">
        <span class="bola"></span>
        <span class="bola"></span>
        <span class="bola"></span>
        <span class="bola"></span>
        <div class="inner">
            <span class="circle one"></span> <span class="circle two"></span> <span class="circle three"></span><span class="bayangan"></span>
            <img src="admin/default/image-4.png" alt="" class="image-1">
            <form action="admin/proses_login.php" method="post" enctype="multipart/form-data">
                <h3 class="h3 text-shadow-dark">Login</h3>
                <div class="form-holder">
                    <input type="text" class="form-control mb-2" id="username" name="username" placeholder="Username Or Email" required>
                </div>
                <div class="form-holder">
                    <input type="password" class="form-control mb-2" id="password" name="password" placeholder="Password" minlength="8" required>
                    <input type="checkbox" id="show-password"> <label for="show-password">Tampilkan Sandi</label>
                    <script>
                        document.getElementById('show-password').addEventListener('change', function() {
                            var passwordInput = document.getElementById('password');
                            if (this.checked) {
                                passwordInput.type = 'text';
                            } else {
                                passwordInput.type = 'password';
                            }
                        });
                    </script>
                </div>
                <button type="submit" class="button">
                    <span>Login</span>
                </button>
                <button type="reset" class="button">
                    <span>Hapus</span>
                </button>
                <hr>
                <a href="index.php" class="button-kembali"><span>Kembali</span></a>
            </form>
            <img src="admin/default/image-2.png" alt="" class="image-2">
        </div>
    </div>

    <script src="admin/js/bootstrap.js"></script>
    <script src="admin/js/jquery-2.1.4.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const balls = document.querySelectorAll('.bola');
            const container = document.querySelector('.wrapper');

            const ballProperties = [];
            const padding = 5;

            balls.forEach(ball => {
                const ballDiameter = ball.offsetWidth;
                const containerWidth = container.clientWidth;
                const containerHeight = container.clientHeight;

                ballProperties.push({
                    ball: ball,
                    x: Math.random() * (containerWidth - ballDiameter - padding * 2) + padding,
                    y: Math.random() * (containerHeight - ballDiameter - padding * 2) + padding,
                    dx: (Math.random() - 0.5) * 6.5, // random speed between -2 and 2
                    dy: (Math.random() - 0.5) * 6.5 // random speed between -2 and 2
                });
            });

            function update() {
                ballProperties.forEach(prop => {
                    prop.x += prop.dx;
                    prop.y += prop.dy;

                    if (prop.x + prop.ball.offsetWidth > container.clientWidth - padding || prop.x < padding) {
                        prop.dx = -prop.dx;
                    }

                    if (prop.y + prop.ball.offsetHeight > container.clientHeight - padding || prop.y < padding) {
                        prop.dy = -prop.dy;
                    }

                    prop.ball.style.transform = `translate(${prop.x}px, ${prop.y}px)`;
                });
                requestAnimationFrame(update);
            }

            update();
        });
    </script>
    <script>
        // Add event listener to the Username input field
        $('#username').on('input', function() {
            var username = $(this).val();
            // Convert to lowercase and remove spaces
            username = username.toLowerCase().replace(/\s+/g, '');
            $(this).val(username);
        });
    </script>
</body>

</html>
