<?php
header('Content-Type: application/json');
include 'db.php'; // Include the database connection

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        fetchTasks($pdo);
        break;
    case 'POST':
        addTask($pdo);
        break;
    case 'PUT':
        completeTask($pdo);
        break;
    case 'DELETE':
        deleteTask($pdo);
        break;
    default:
        echo json_encode(['message' => 'Method not allowed']);
        break;
}

function fetchTasks($pdo) {
    $stmt = $pdo->query("SELECT * FROM tasks");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
}

function addTask($pdo) {
    $data = json_decode(file_get_contents("php://input"));
    $task = $data->task;

    $stmt = $pdo->prepare("INSERT INTO tasks (task, status) VALUES (:task, 'pending')");
    $stmt->bindParam(':task', $task);
    $stmt->execute();

    echo json_encode(['message' => 'Task added successfully']);
}

function completeTask($pdo) {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;

    $stmt = $pdo->prepare("UPDATE tasks SET status = 'completed' WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['message' => 'Task completed successfully']);
}

function deleteTask($pdo) {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;

    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['message' => 'Task deleted successfully']);
}
?>