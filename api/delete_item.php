<?php
include "../database/connection.php";

if(isset($_GET["item_id"])){
    $item_id = (int)$_GET["item_id"];
    if(is_numeric($item_id)){
        // Delete item from tbl_request
        $query = "DELETE FROM tbl_request WHERE item_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $item_id);
        mysqli_stmt_execute($stmt);

        // Delete item from tbl_item
        $query = "DELETE FROM tbl_item WHERE item_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $item_id);
        $response = mysqli_stmt_execute($stmt);
        // if the response is correct
        if($response){
            header("Location: ../pages/Item.php?success=Successfully deleted");
            exit();
        } else {
            header("Location: ../pages/Item.php?error=Failed to delete item");
            exit();
        }
    } else {
        echo "is not numeric";
    }
}
?>
