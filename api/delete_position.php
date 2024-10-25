<?php
include "../database/connection.php";
// check if the data is set
if (isset($_GET["position_id"])) {
    $position_id = (int)$_GET["position_id"];
    // check if the position is numeric
    if (is_numeric($position_id)) {
        try {
            // preparing the query deletion of position
            $query = "DELETE FROM tbl_position WHERE position_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $position_id);
            $response = mysqli_stmt_execute($stmt);

            // check if the response is true
            if ($response) {
                header("Location: ../pages/Position.php?success=Position successfully deleted");
                exit();
            } else {
                header("Location: ../pages/Position.php?error=Failed to delete Position, Please try again!");
                exit();
            }
        } catch (Exception $error) {
             // If the position is currently used by the employee then display the error message
            header("Location: ../pages/Position.php?error=Cannot delete Position data. The Position is currently in use by employees. Please remove associated employees before deleting the position.");
            exit();
        }
    } else {
        header("Location: ../pages/Position.php?error=Failed to delete position");
        exit();
    }
}
