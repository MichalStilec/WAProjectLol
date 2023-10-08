<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the submitted data (you can add more validation if needed)
    if (empty($username) || empty($password)) {
        echo "Please fill in all the fields.";
        exit;
    }

    // Check if the user exists in the JSON file
    $users = getUsers();
    $user = findUser($username, $users);
    if (!$user) {
        echo "Invalid username or password.";
        exit;
    }

    // Verify the password
    if (!password_verify($password, $user['password'])) {
        echo "Invalid username or password.";
        exit;
    }

}

function getUsers()
{
    $data = file_get_contents('users.json');
    return json_decode($data, true);
}

function findUser($username, $users)
{
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return $user;
        }
    }
    return null;
}
?>
