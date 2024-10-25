<?php
include "../database/connection.php";
include "../utils/functions.php";
include "../utils/send_email.php";
$routes = "";
// check if the data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = validateData($_POST["email"]);

    // check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $routes = "../pages/Forgot_Password.php?error=Invalid email address";
    } else {
        // preparing the query
        $query = "SELECT * FROM tbl_employee WHERE employee_email = ?";
        $stmt = mysqli_prepare($connection, $query);
        // if the stmt is not successful then return
        if (!$stmt) {
            $routes = "..pages/Forgot_Password.php?error=Something went wrong";
            die("Connection Error : " . mysqli_error($connection));
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        // check if there are any rows
        if ($row > 0) {
            // check if the the employee is not deleted
            if ($row["is_deleted"] === 0) {

                // generate a random characters
                $token = bin2hex(random_bytes(16));
                $token_hash = hash("sha256", $token); //hash the token with sha256
                $expiry = date("Y-m-d H:i:s", time() + 60 * 30); // add expiration (current time + 60 * 30 = 1,800 seconds) equivalent of to 30 minutes  
                // prepare the query
                $query = "UPDATE tbl_employee SET reset_token_hash = ?, reset_token_expires_at = ? WHERE employee_email = ?";
                $stmt = mysqli_prepare($connection, $query);

                if (!$stmt) {
                    $routes = "..pages/Forgot_Password.php?error= Something went wrong";
                    die("Connection Error : " . mysqli_error($connection));
                }

                mysqli_stmt_bind_param($stmt, "sss", $token_hash, $expiry, $email);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    $subject = "Reset Password";
                    $message = "Hi $email this is your link for resetting your password <a href='http://localhost:3000/pages/Reset_Password.php?token=$token'>Reset</a>";
                    $response = sendEmail($email, $subject, $message);
                    if ($response) {
                        $routes = "../pages/Forgot_Password.php?success=We sent to your email the password reset link.";
                    } else {
                        $routes = "../pages/Forgot_Password.php?success=We encounter some problems while sending the reset password, please try again later.";
                    }
                } else {
                    $routes = "../pages/Forgot_Password.php?error=Something went wrong, Please try again.";
                }
            } else {
                $routes = "../pages/Forgot_Password.php?error=Something went wrong, Please try again";
            }
        } else {
            $routes = "../pages/Forgot_Password.php?error=Email address is incorrect.";
        }
    }
}

header("Location: $routes");
exit();
