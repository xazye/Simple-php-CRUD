<?php

include 'partials/header.php';

require __DIR__ . '/users/users.php';

$errors = [
    'name' => "",
    'username' => "",
    'email' => "",
    'phone' => "",
    'website' => "",
];
$user = [
    'id' => '',
    'name' => '',
    'username' => '',
    'email' => '',
    'phone' => '',
    'website' => '',
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = array_merge($user, $_POST);
    $isValid = validateUser($_POST, $errors);


    if ($isValid) {
        $user = createUser($_POST);
        echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";

        uploadImage($_FILES['picture'], $user);

        header("Location: index.php");
    }
}

?>

<?php include "_form.php" ?>

<?php include 'partials/footer.php' ?>