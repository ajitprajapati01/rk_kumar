<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "ajxcrud");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// agar already login hai to direct ind.php bhej do
if (isset($_SESSION['email'])) {
    header("Location: ind.php");
    exit();
}

$error_email = $error_pass = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    if ($email == "") {
        $error_email = "Email is required";
    }
    if ($pass == "") {
        $error_pass = "Password is required";
    }

    if ($error_email == "" && $error_pass == "") {
        $sql = "SELECT * FROM testing WHERE email='$email' AND password='$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['email'] = $email;
            header("Location: ind.php");
            exit();
        } else {
            echo "<script>alert('Invalid email or password');</script>";
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body{
            background: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .container{
            width: 350px;
            margin: 100px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
            text-align: center;
        }
        h2{
            margin-bottom: 20px;
            color: #333;
        }
        .field{
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn{
            width: 95%;
            padding: 10px;
            background: #007BFF;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover{
            background: #0056b3;
        }
        .error{
            color: red;
            font-size: 13px;
            text-align: left;
            margin: 0 0 10px 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Please Login</h2>
        <form action="" method="POST" id="loginForm">
            <input type="text" class="field" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br>
            <div class="error"><?php echo $error_email; ?></div>

            <input type="password" class="field" name="password" placeholder="Password"><br>
            <div class="error"><?php echo $error_pass; ?></div>

            <button type="submit" class="btn" name="login">Login</button>
        </form>
    </div>
</body>
</html>
