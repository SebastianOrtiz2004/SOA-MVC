<?php
require_once __DIR__ . '/Conexion.php';

class CrudInsert {
    public static function crear(array $d): array {
        $pdo = Conexion::conectar();
        $st  = $pdo->prepare("INSERT INTO estudiantes (cedula, nombre, apellido, direccion, telefono) VALUES (?,?,?,?,?)");
        $ok  = $st->execute([
            $d['cedula']   ?? null,
            $d['nombre']   ?? null,
            $d['apellido'] ?? null,
            $d['direccion']?? null,
            $d['telefono'] ?? null,
        ]);
        return $ok ? ['success'=>true, 'message'=>'Creado'] : ['success'=>false, 'error'=>'No se pudo crear'];
    }
}
