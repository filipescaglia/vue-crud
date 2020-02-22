<?php

$conn = new PDO("mysql:dbname=vue_crud;host=localhost", "root", "");

try {
    $conn;
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$result = array('error' => false);
$action = '';

if(isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == 'read') {
    $sql = "SELECT * FROM users";
    $sql = $conn->query($sql);
    $users = array();

    $result['users'] = $sql->fetchAll();
}

if($action == 'create') {
    $name = addslashes($_POST['name']);
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);

    $sql = "INSERT INTO users SET name = :name, email = :email, phone = :phone";
    $sql = $conn->prepare($sql);
    $sql->bindValue(":name", $name);
    $sql->bindValue(":email", $email);
    $sql->bindValue(":phone", $phone);

    if($sql->execute()) {
        $result['message'] = "User added successfully!";
    } else {
        $result['error'] = true;
        $result['message'] = "Failed to add user!";
    }    
}

if($action == 'update') {
    $id = addslashes($_POST['id']);
    $name = addslashes($_POST['name']);
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);

    $sql = "UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id";
    $sql = $conn->prepare($sql);
    $sql->bindValue(":id", $id);
    $sql->bindValue(":name", $name);
    $sql->bindValue(":email", $email);
    $sql->bindValue(":phone", $phone);

    if($sql->execute()) {
        $result['message'] = "User updated successfully!";
    } else {
        $result['error'] = true;
        $result['message'] = "Failed to update user!";
    }    
}

if($action == 'delete') {
    $id = addslashes($_POST['id']);

    $sql = "DELETE FROM users WHERE id = :id";
    $sql = $conn->prepare($sql);
    $sql->bindValue(":id", $id);

    if($sql->execute()) {
        $result['message'] = "User deleted successfully!";
    } else {
        $result['error'] = true;
        $result['message'] = "Failed to delete user!";
    }    
}

echo json_encode($result);