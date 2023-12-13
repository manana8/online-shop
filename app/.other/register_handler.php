<?php
function validate(array $data) {

    $errors = [];

    if(isset($data['name'])) {
        $name = $data['name'];
        if (strlen($name) < 2) {
            $errors['name'] = 'Имя должно содержать более 2 символов';
        }
    }  else {
        $errors['name'] = 'Введите имя';
    }

    if(isset($data['email'])) {
        $email = $data['email'];
        if (strlen($email) < 4) {
            $errors['email'] = 'Электронная почта должна содержать более 4 символов';
        } elseif (!strpos($email, '@')) {
            $errors['email'] = 'Некорректная почта';
        }
    } else {
        $errors['email'] = 'Введите адрес электронной почты';
    }

    if(isset($data['psw'])) {
        $password = $data['psw'];
        if (strlen($password) < 6) {
            $errors['psw'] = 'Пароль должен содержать 6 символов';
        }
    } else {
        $errors['psw'] = 'Введите пароль';
    }


    if(isset($data['psw-repeat'])) {
        $passwordRep = $data['psw-repeat'];
        if ($password !== $passwordRep) {
            $errors['psw-repeat'] = 'Пароли не совпадают';
        }
    } else {
        $errors['psw-repeat'] = 'Введите пароль';
    }

    return $errors;
}

$errors = validate($_POST);

if (empty($errors)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];

    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();

    $data = $stmt->fetchAll();

    print_r($data);
}

?>

<form action="register_handler.php" method="POST">
    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <?php if (isset($errors['name'])): ?>
            <label style="color: red"><?php echo $errors['name']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter Name" name="name" id="name" required>

        <label for="email"><b>Email</b></label>
        <?php if (isset($errors['email'])): ?>
            <label style="color: red"><?php echo $errors['email']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter Email" name="email" id="email" required>

        <label for="psw"><b>Password</b></label>
        <?php if (isset($errors['psw'])): ?>
            <label style="color: red"><?php echo $errors['psw']; ?></label>
        <?php endif; ?>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <?php if (isset($errors['psw-repeat'])): ?>
            <label style="color: red"><?php echo $errors['psw-repeat']; ?></label>
        <?php endif; ?>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="#">Sign in</a>.</p>
    </div>
</form>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: white;
    }

    * {
        box-sizing: border-box;
    }

    /* Add padding to containers */
    .container {
        padding: 16px;
        background-color: white;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit button */
    .orderbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .orderbtn:hover {
        opacity: 1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>
