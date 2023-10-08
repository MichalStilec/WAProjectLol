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

    // Check if the user already exists in the JSON file
    $users = getUsers();
    if (userExists($username, $users)) {
        echo "Username already exists. Please choose a different username.";
        exit;
    }

    // Add the new user to the users array
    $users[] = [
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT) // Store hashed password
    ];

    // Save the updated users array to the JSON file
    saveUsers($users);

    echo "Registration successful. You can now login.";
}

function getUsers()
{
    $data = file_get_contents('users.json');
    return json_decode($data, true);
}

function saveUsers($users)
{
    $data = json_encode($users);
    file_put_contents('users.json', $data);
}

function userExists($username, $users)
{
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return true;
        }
    }
    return false;
}
?>
