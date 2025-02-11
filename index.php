<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $grade = $_POST['grade'];

    // Name validation
    if (!preg_match("/^[a-zA-Z' ]+$/", $name)) {
        echo "Invalid name";
        exit;
    }

        // Check if name already exists
        $nameCheck = "SELECT COUNT(*) FROM student WHERE name = :name";
        $stmtName = $conn->prepare($nameCheck);
        $stmtName->bindParam(':name', $name);
        $stmtName->execute();
        $nameCount = $stmtName->fetchColumn();
    
        if ($nameCount > 0) {
            echo "The name '$name' already exists.";
            exit;
        }

    // Email validation
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    if (!preg_match($pattern, $email)) {
        echo "The email address '$email' is considered invalid.";
        exit;
    }

        // Check if email already exists
        $emailCheck = "SELECT COUNT(*) FROM student WHERE email = :email";
        $stmtEmail = $conn->prepare($emailCheck);
        $stmtEmail->bindParam(':email', $email);
        $stmtEmail->execute();
        $emailCount = $stmtEmail->fetchColumn();
    
        if ($emailCount > 0) {
            echo "The email address '$email' already exists.";
            exit;

        }
        

    // Phone number validation
    function isValidPhoneNumber($phone) {
        $pattern = "/^\+?[0-9]{8,15}$/";
        return preg_match($pattern, $phone);
    }

    if (!isValidPhoneNumber($phone)) {
        echo "The phone number is invalid. Only numeric characters and an optional plus sign are allowed, with a length of 8 to 15 digits.";
        exit;
    }

    $phoneCheck = "SELECT COUNT(*) FROM student WHERE phone = :phone";
    $stmtPhone = $conn->prepare($phoneCheck);
    $stmtPhone->bindParam(':phone', $phone);
    $stmtPhone->execute();
    $phoneCount = $stmtPhone->fetchColumn();

    if ($phoneCount > 0) {
        echo "The phone number '$phone' already exists.";
        exit;
    }

    // Grade validation
    function isValidGrade($grade) {
        $pattern = "/^[a-zA-Z0-9+\-\s]*$/";
        return preg_match($pattern, $grade);
    }

    if (!isValidGrade($grade)) {
        echo "The grade is invalid. Only alphanumeric characters and common grade symbols are allowed.";
        exit;
    }

    // Prepare and execute the SQL query
    $sql = "INSERT INTO student (name, email, phone, grade) VALUES (:name, :email, :phone, :grade)";
    $result = $conn->prepare($sql);
    $result->bindParam(':name', $name);
    $result->bindParam(':email', $email);
    $result->bindParam(':phone', $phone);
    $result->bindParam(':grade', $grade);

    if ($result->execute()) {
        // echo "Data inserted successfully.";
        header('Location: dashboard.php'); 
    } else {
        echo "Error inserting data.";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CRUD || APP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Contact Form</h2>
        <form action="#" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                <input type="text" id="name" name="name" required
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                <input type="tel" id="phone" name="phone" required
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="grade" class="block text-gray-700 font-semibold mb-2">Grade</label>
                <input type="text" id="grade" name="grade" required
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-center">
                <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Add
                </button>
            </div>
        </form>
    </div>

</body>
</html>
