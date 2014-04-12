<?php
/**
 * Demo for PHPNE Full Text Demo
 *
 * @author Tom Walder <tom@docnet.nu>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Search object
    require_once('../src/Search.php');
    $obj_search = new Search();

    // Execute Query
    if(isset($_POST['search'])) {
        echo json_encode($obj_search->query($_POST['search']), JSON_PRETTY_PRINT);
    }

    // Create Document
    if(isset($_POST['title'])) {
        echo json_encode($obj_search->createDoc($_POST['title'], $_POST['content']), JSON_PRETTY_PRINT);
    }

}
