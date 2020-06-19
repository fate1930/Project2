<!doctype html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <div class="logo">
        <h1>
            <img src="../images/others/logo.jpg">
        </h1>
        <p>Welcome To TPS!!!</p>
    </div>
</header>
<section>
    <form action="login1.php" method="post">
        <p class="firstline">Username/E-mail:</p>
        <p>
            <input type="text" name="username" required>
        </p>
        <p>Password:</p>
        <p>
            <input type="password" name="password" pattern="^[0-9a-zA-Z]{8,}$" required>
        </p>
        <p>
            <input type="submit" value="Sign in" name="continue">
        </p>
    </form>
</section>
<div id="toregister">
    <p>New to TPS?<a href="register.php">Create a new account?</a></p>
</div>
<footer>
    <div class="footer">
        <p>©19软工张璐.备案号：19302010023</p>
    </div>
</footer>
</body>
</html>
