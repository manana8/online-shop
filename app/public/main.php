<?php


//if (isset($_COOKIE['user_id'])) {
    //print_r($_COOKIE['user_id']);

session_start();
if (isset($_SESSION['user_id'])) {
    //print_r($_SESSION['user_id']);

    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll();
//    print_r($products);
//    exit();
} else {
    header('location: /login.php');
}

?>

<body>
<h3>Catalog</h3>
<div class="container">
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
        <div class="card text-center">
            <div class="card-header">
                Hit!
                <a href="#">
                    <img class="card-img-top" src=<?php echo $product['image']; ?> alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $product['name']; ?> </p>
                        <a><h5 class="card-title">Description!</h5></a>
                        <div class="card-footer">
                            <?php echo $product['price'] . " rub"; ?>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>

<style>
    body {
        font-family: "Josefin Slab";
    }

    h3 {
        font-size: 2.2rem;
        margin-top: 80px;
        text-align: center;
        color: navy;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        max-width: 255px;
        margin: 1vw auto;
        position: relative;
    }

    a {
        text-align: center;
        color: darkblue;
        text-decoration: none;
    }

    a:hover {
        text-align: center;
        color: maroon;
        text-decoration: none;
    }

    .card {
        max-width: 16rem;
        margin-bottom: 6px;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        text-align: center;
        font-size: 13px;
        color: red;
        background-color: white;
        margin-bottom: 6px;
    }

    .card-img-top{
        max-width:16rem;
    }

    .text-muted {
        text-align: center;
        font-weight: bold;
        font-size: 40px;
    }

    .card-title{
        text-align: center;
        font-size: 14px;
        color: cornflowerblue;
        background-color: white;
    }

    .card-footer{
        text-align: center;
        font-weight: bold;
        color: navy;
        font-size: 20px;
        background-color: white;
    }

</style>

