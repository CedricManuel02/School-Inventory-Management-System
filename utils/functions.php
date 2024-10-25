<?php
function validateData($data){
    return htmlspecialchars(stripslashes(trim($data)));
}
?>