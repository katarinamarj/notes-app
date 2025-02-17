<?php
require_once '../config/mysql.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': 
        $data = json_decode(file_get_contents("php://input"), true);
        $title = $data['title'];
        $description = $data['description'];

        $stmt = $pdo->prepare("INSERT INTO notes (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
        echo json_encode(["message" => "Note created successfully in MySQL"]);
        break;

    case 'GET': 
        $stmt = $pdo->query("SELECT * FROM notes");
        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($notes);
        break;

    case 'PUT': 
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $title = $data['title'];
        $description = $data['description'];

        $stmt = $pdo->prepare("UPDATE notes SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
        echo json_encode(["message" => "Note updated successfully in MySQL"]);
        break;

        case 'DELETE': 
            $data = json_decode(file_get_contents("php://input"), true);
        
            if (isset($data['id'])) { 
                $id = $data['id'];
                $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode(["message" => "Note deleted successfully from MySQL", "deletedCount" => $stmt->rowCount()]);
            } elseif (isset($data['ids']) && is_array($data['ids'])) { 
                $ids = $data['ids'];
                if (!empty($ids)) {
                    $placeholders = implode(',', array_fill(0, count($ids), '?'));
                    $sql = "DELETE FROM notes WHERE id IN ($placeholders)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($ids);
                    echo json_encode(["message" => "Notes deleted successfully from MySQL", "deletedCount" => $stmt->rowCount()]);
                } else {
                    echo json_encode(["message" => "No IDs provided for deletion"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Invalid request"]);
            }
            break;
        
    
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}
