<?php
header('Content-Type: application/json');

// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo_app";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// End Konfigurasi


// untuk get seluruh data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM todos";
    $result = $conn->query($sql);

    $todos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $todos[] = $row;
        }
    }
    // convert ke data json
    echo json_encode($todos);

    // end get data

    // untuk create data
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    $task = $data->task;

    $sql = "INSERT INTO todos (task) VALUES ('$task')";
    $conn->query($sql); 

    // end create data

    // ngubah status completed 
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $id = $_GET['id'];
    $sql = "UPDATE todos SET completed = NOT completed WHERE id = $id";
    $conn->query($sql);
    // end ubah

    // delete data
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];

    $sql = "DELETE FROM todos WHERE id = $id";
    $conn->query($sql);
}
    // end delete
    
$conn->close();
?>
