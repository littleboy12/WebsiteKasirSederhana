<?php require_once "../public/login.php"; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Toko</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-header">
            <h2>Login ke Toko</h2>
            <p>Silakan masukkan detail Anda untuk masuk</p>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label for="Username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username" required>
                <?php if (isset($error['errUsername'])): ?>
                    <p style="color: red;"><?php echo $error['errUsername']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan kata sandi" required>
                <?php if (isset($error['errPassword'])): ?>
                    <p style="color: red;"><?php echo $error['errPassword']; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" name="login" class="btn btn-custom btn-block">Masuk</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>