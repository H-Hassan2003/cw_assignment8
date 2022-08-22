<?php

session_start();

if (!isset($_SESSION["verified"])) {
    header("location: login_file.php");
}

$auth_user = $_SESSION["auth_user"];

$SQL_connection = new mysqli("localhost", "root", "", "codeweekend");

// $SQL_query = $SQL_connection->query(' DELETE FROM products WHERE id = 1; ');
// $SQL_query = $SQL_connection->query(' DELETE FROM products WHERE id = 2; ');
// $SQL_query = $SQL_connection->query(' DELETE FROM products WHERE id = 3; ');
// $SQL_query = $SQL_connection->query(' DELETE FROM products WHERE id = 4; ');
// $SQL_query = $SQL_connection->query(' DELETE FROM products WHERE id = 5; ');


$SQL_query = ' SELECT * FROM products; ';
$selected_Data = $SQL_connection->query($SQL_query);
$selected_Products = $selected_Data->fetch_all(MYSQLI_ASSOC);


?>

<style>

    html, body {
        margin: 0;
        padding: 0;
        font-weight: 600;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        text-align: center;
    }

    td img {
        width: 80px;
    }

    fieldset {
        border-bottom-left-radius: 1em;
        border-top-right-radius: 1em;
        background-color: lightblue;
        
    }

    .grocery_container {
        width: 90%;
    }

    table {
        text-align: center;
        margin: 0 auto;
    }

    .whole_container {
        max-width: 100vw;
        height: 100vh;
    }

    .hero {
        background-image: linear-gradient(to right, orange, gold);
        padding: 1em;
    }

    .container {
        background-image: url("http://localhost/codeweekendphp5/background_images/grocery.webp");
        background-size: cover;
        background-position: center;
        padding: 1em;
        text-align: center;
    }

    a {
        text-decoration: none;
        color: orangered;
    }

    a:hover,
    a:focus {
        color: darkred;
        font-weight: 900;
        cursor: pointer;
    }

    form {
        border: solid orangered 1px;
        padding: 1em;
        border-radius: 1em;
    }

    .save_cancel {
        display: block;
        text-align: center;
        padding: 0.3em 1em;
        border: ridge 1px purple;
        border-radius: 4px;
        color: darkblue;
        font-weight: 600;
        font-size: 16px;
        background-color: palevioletred;
        margin: 3px auto;
    }

    .save_cancel:hover,
    .save_cancel:focus {
        color: black;
        background-color: olivedrab;
        cursor: pointer;
    }

    .table {
        background-color: lightcoral;
        border: solid orange;
        border-radius: 1em;
        text-align: center;
    }

    input {
        border-radius: 4px;
        padding: 0.3em;
        border: none;
        font-weight: 600;
    }

    .edit_delete {
        border: solid 1px goldenrod;
    }

</style>

<div class="whole_container">

    <header class="hero">
        <h3>
            Welcome <strong><?php echo $auth_user["name"]. "👋" ?></strong>
        </h3>
        <p>
            <a href="http://localhost/codeweekendphp5/login_backend_file.php?logout=true">Logout</a>
        </p>
    </header>

    <?php

        $currently_selected_product_for_edit = null;

        if (isset($_GET["edit_product"])) {
            $id = $_GET["edit_product"];

            $select_product_for_Edit_query = " SELECT * FROM products WHERE id = ${id} ";

            $selected_product_for_edit = $SQL_connection->query($select_product_for_Edit_query);

            $currently_selected_product_for_edit = $selected_product_for_edit->fetch_assoc();


    }

    ?>
    <div class="container">
        <form action="http://localhost/codeweekendphp5/products_file.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="product_Id" value="<?php echo ($currently_selected_product_for_edit) ? $currently_selected_product_for_edit['id'] : '' ?>">

            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>
                        <input type="text" name="product_Name" value="<?php echo ($currently_selected_product_for_edit) ? $currently_selected_product_for_edit["name"] : "";  ?>">
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>
                        <input type="number" name="product_Price" value="<?php echo ($currently_selected_product_for_edit) ? $currently_selected_product_for_edit["price"] : "";  ?>">
                    </td>
                </tr>
                <tr>
                    <td>Expiry Date</td>
                    <td>
                        <input type="date" name="product_Expiry_date" value="<?php echo ($currently_selected_product_for_edit) ? $currently_selected_product_for_edit["expiry_date"] : ""; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td>
                        <input type="file" name="product_Image">
                        <?php if($currently_selected_product_for_edit) {
                            ?>
                            <img src="file_storage/products_files/<?php echo $currently_selected_product_for_edit["image"] ?>" alt="">
                        <?php } ?>
                    </td>
                </tr>
                <div class="save_cancel_div">
                <tr>
                    <td>
                        <button class="save_cancel" type="submit" name=" <?php echo ($currently_selected_product_for_edit) ?"update_Products" : "save_Products" ?>" >Save</button>
                        <a class="save_cancel" href="home.php">Cancel</a>
                    </td>
                </tr>
                </div>
            </table>
        </form>

        <fieldset>
            <legend>GROCERIES</legend>

            <div class="grocery_container">
            <table border="1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Expiry Date</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $id = 1;
                        foreach($selected_Products as $selected_Product) {
                            echo    "<tr>
                                        <td>". $id++ ."</td>
                                        <td>". $selected_Product['name'] ."</td>
                                        <td>". $selected_Product['price'] ."</td>
                                        <td>". ( $selected_Product['expiry_date'] ? $selected_Product['expiry_date'] : "<i>Date Not Set</i>" ) ."</td>
                                        <td>
                                            <img src='file_storage/products_files/{$selected_Product['image']}'
                                        </td>
                                        <td>

                                            <a class'edit_delete' href='http://localhost/codeweekendphp5/home.php?edit_product={$selected_Product['id']}'>Edit</a>
                                            <br>
                                            <a class'edit_delete' href='http://localhost/codeweekendphp5/products_file.php?delete_product={$selected_Product['id']}'>Delete</a>

                                        </td>
                                    </tr>";
                        }
                    ?>
                </tbody>
            </table>
            </div>
        </fieldset>
    </div>

</div>