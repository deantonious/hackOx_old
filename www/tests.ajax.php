<?php 
    echo "TEST: \n";

    print_r($_FILES);
    print_r($_POST);
    
    echo file_get_contents('php://input');

?>