<?php
require_once 'db.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        $result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
        $tasks = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($tasks);
    }

    if ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['task']) && !empty(trim($data['task']))) {
            $task = $conn->real_escape_string(trim($data['task']));
            $conn->query("INSERT INTO tasks (task, status) VALUES ('$task', 'pending')");
            echo json_encode(["success" => true, "message" => "Task added successfully"]);
        } else {
            throw new Exception("Task description is missing.");
        }
    }

    if ($method === 'PUT') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id']) && is_numeric($data['id'])) {
            $id = $conn->real_escape_string($data['id']);
            $conn->query("UPDATE tasks SET status = 'completed' WHERE id = '$id'");
            echo json_encode(["success" => true, "message" => "Task marked as completed"]);
        } else {
            throw new Exception("Invalid task ID.");
        }
    }

    if ($method === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id']) && is_numeric($data['id'])) {
            $id = $conn->real_escape_string($data['id']);
            $conn->query("DELETE FROM tasks WHERE id = '$id'");
            echo json_encode(["success" => true, "message" => "Task deleted successfully"]);
        } else {
            throw new Exception("Invalid task ID.");
        }
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
