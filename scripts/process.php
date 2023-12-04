<?php

$errors = [];
$data = [];

//Connect to Postgresql database
$surestore_db = pg_connect("host=localhost dbname=SureStore user=postgres password=97DnXjPQSUu$925atBo!9WZuAf@7aaWQ");

pg_close($connect);
// Initialize arrays for error messages and data

// Return error text if fields are empty
if (empty($_POST['username'])) {
    $errors['username'] = 'Username is required.';
}

if (empty($_POST['password'])) {
    $errors['password'] = 'Password is required.';
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $data['success'] = true;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>