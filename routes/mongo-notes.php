<?php
require_once '../config/mongo.php'; 
header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': 
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['title'], $data['description'])) {
            $mongoCollection->insertOne([
                'title' => $data['title'],
                'description' => $data['description'],
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ]);
            echo json_encode(["message" => "Note created successfully"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input"]);
        }
        break;

    case 'GET': 
        $notes = $mongoCollection->find()->toArray();
        echo json_encode($notes);
        break;

    case 'PUT': 
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['_id']) && preg_match('/^[a-f\d]{24}$/i', $data['_id'])) {
            $id = new MongoDB\BSON\ObjectId($data['_id']);
            $update = [
                'title' => $data['title'] ?? "",
                'description' => $data['description'] ?? ""
            ];
            $mongoCollection->updateOne(['_id' => $id], ['$set' => $update]);
            echo json_encode(["message" => "Note updated successfully"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Invalid ID"]);
        }
        break;
        

        case 'DELETE': 
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['_id']) && preg_match('/^[a-f\d]{24}$/i', $data['_id'])) { 
                $id = new MongoDB\BSON\ObjectId($data['_id']);
                $mongoCollection->deleteOne(['_id' => $id]);
                echo json_encode(["message" => "Note deleted successfully"]);
            } elseif (isset($data['ids']) && is_array($data['ids'])) { 
                $ids = array_filter($data['ids'], function ($id) {
                return preg_match('/^[a-f\d]{24}$/i', $id);
            });
            
            if (!empty($ids)) {
                $mongoCollection->deleteMany(['_id' => ['$in' => array_map(fn($id) => new MongoDB\BSON\ObjectId($id), $ids)]]);
                echo json_encode(["message" => "Notes deleted successfully"]);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Invalid IDs"]);
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
