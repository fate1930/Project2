<!doctype html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/register.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <div class="logo">
        <h1>
            <img src="../images/others/logo.jpg">
        </h1>
        <p>Sign Up For TPS!!!</p>
    </div>
</header>
<section>
    <form action="register1.php" method="post">
        <p class="firstline">Username:</p>
        <p>
            <input type="text" name="username" pattern="^[a-zA-Z0-9_]*$" required>
        </p>
        <p>E-mail:</p>
        <p>
            <input type="email" name="email" pattern="^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$" required>
        </p>
        <p>Password:</p>
        <p>
            <input type="password" name="password" pattern="^[0-9a-zA-Z]{8,}$" required>
        </p>
        <p>Confirm Your Password</p>
        <p>
            <input type="password" name="repassword" pattern="^[0-9a-zA-Z]{8,}$" required>
        </p>
        <p>
            <input type="submit" value="Sign up" name="continue">
        </p>
    </form>
</section>
<footer>
    <div class="footer">
        <p>©19软工张璐.备案号：19302010023</p>
    </div>
</footer>
</body>
</html>