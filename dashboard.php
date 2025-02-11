<?php

require_once('connection.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $roll = $_POST['roll'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $grade = $_POST['grade'];
}

$sql = "SELECT * FROM student";
$result = $conn->prepare($sql);
$result->execute();
// var_dump($user['roll']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Student Data Table</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100 p-4">

    <div class="w-full max-w-4xl bg-white rounded shadow-md overflow-x-auto">
        <h2 class="text-2xl font-bold mb-4 text-center p-4">Student Data</h2>
        <table class="w-full table-auto border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Phone</th>
                    <th class="border border-gray-300 px-4 py-2">Grade</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while($user = $result->fetch(PDO::FETCH_ASSOC)) {  
               echo "<tr>";
               echo "<td class='border border-gray-300 px-4 py-2'>" .$user['roll'] . "</td>";
               echo "<td class='border border-gray-300 px-4 py-2'>" .$user['name'] . "</td>";
               echo "<td class='border border-gray-300 px-4 py-2'>" .$user['email'] . "</td>";
               echo "<td class='border border-gray-300 px-4 py-2'>" .$user['phone'] . "</td>";
               echo "<td class='border border-gray-300 px-4 py-2'>" .$user['grade'] . "</td>";
               echo "<td class='border border-gray-300 px-4 py-2'>";
               echo "<a href='update.php?update=" . $user['roll'] . "' class='bg-blue-500 text-white px-2 py-1 rounded mr-2 hover:bg-blue-600'>Update</a>";
               echo "<button onclick='deleteItem(".$user['roll'].")". "' class='bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600'>Delete</button>";
               echo "</td>";
               echo "</tr>";
                }
               
                ?>
            </tbody>
        </table>
        <div class="mt-20 mb-5 flex items-center justify-center" >
            <button class="bg-purple-500 text-white px-2 py-1 rounded hover:bg-purple-600"><a href="index.php"> Add More </a></button>
        </div>
    </div>

    <script>
        function deleteItem(id){
            if(confirm("Are you sure you want to delete this record?")){
                window.location.href = "delete.php?delete="+id;
            }
        }
    </script>
</body>
</html>
