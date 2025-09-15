<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../Models/Select.php';
require_once __DIR__ . '/../Models/Insert.php';
require_once __DIR__ . '/../Models/Update.php';
require_once __DIR__ . '/../Models/Delete.php';

function body_json(): array {
    $raw = file_get_contents('php://input');
    $d   = json_decode($raw, true);
    return is_array($d) ? $d : [];
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            if (!empty($_GET['cedula'])) {
                $uno = CrudSelect::porCedula($_GET['cedula']);
                echo json_encode($uno ?? []);
            } else {
                echo json_encode(CrudSelect::todos());
            }
            break;

        case 'POST':
            $d  = body_json();
            $r  = CrudInsert::crear($d);
            echo json_encode($r);
            break;

        case 'PUT':
            $d  = body_json();
            $r  = CrudActualizar::actualizar($d);
            echo json_encode($r);
            break;

        case 'DELETE':
            $ced = $_GET['cedula'] ?? '';
            if (!$ced) {
                http_response_code(400);
                echo json_encode(['success'=>false,'error'=>'cedula requerida']);
                break;
            }
            echo json_encode(CrudEliminar::eliminar($ced));
            break;

        default:
            http_response_code(405);
            echo json_encode(['success'=>false,'error'=>'Método no permitido']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success'=>false, 'error'=>$e->getMessage()]);
}
