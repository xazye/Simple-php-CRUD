<?php

function getUsers()
{
    return json_decode(file_get_contents(__DIR__ . '\users.json'), true);
}

function getUserById($id)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['id'] == $id)
            return $user;
    }
    unset($user);
    return null;
}
function createUser($data)
{
    $users = getUsers();
    // naively assuming .json is in order by id
    $data['id'] = end($users)['id'] + 1;
    $users[] = $data;
    putJson($users);
    return $data;
}
function updateUser($data, $id)
{
    $updateUser = [];
    $users = getUsers();
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            $users[$i] = $updateUser = array_merge($user, $data);
        }
    }
    unset($user);
    putJson($users);
    return $updateUser;
}
function deleteUser($id)
{
    $users = getUsers();
    foreach ($users as $i => $user) {
        if ($user['id'] === (int)$id) {
            array_splice($users, $i, 1);
        }
    }
    unset($user);
    putJson($users);
}
function uploadImage($file, $user)
{
    if (!isset($file) || !$file['name']) return;

    if (!is_dir(__DIR__ . "/images")) {
        mkdir(__DIR__ . "/images");
    }
    $filename = $file['name'];
    $dotposition = strpos($filename, '.');
    $extension = substr($filename, $dotposition + 1);
    move_uploaded_file($file['tmp_name'], __DIR__ . "/images/{$user['id']}.{$extension}");
    $user['extension'] = $extension;
    updateUser($user, $user['id']);
}
function putJson($data)
{
    file_put_contents(__DIR__ . '\users.json', json_encode($data));
}
function validateUser($user, &$errors)
{
    $isValid = true;
    // Start of validation
    if (!$user['name']) {
        $isValid = false;
        $errors['name'] = 'Name is required';
    }
    if (!$user['username'] || strlen($user['username']) < 6 || strlen($user['username']) > 16) {
        $isValid = false;
        $errors['username'] = 'Username is required and it must be more than 6 and less then 16 character';
    }
    if ($user['email'] && !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        $errors['email'] = 'Not a valid email address';
    }

    if (!filter_var($user['phone'], FILTER_VALIDATE_INT)) {
        $isValid = false;
        $errors['phone'] = 'Not a valid phone number';
    }
    // End Of validation

    return $isValid;
}
