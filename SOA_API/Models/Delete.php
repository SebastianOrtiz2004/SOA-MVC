<?php
require_once __DIR__ . '/Conexion.php';

class CrudEliminar {
    public static function eliminar(string $cedula): array {
        $pdo = Conexion::conectar();
        $st  = $pdo->prepare("DELETE FROM estudiantes WHERE cedula = ?");
        $ok  = $st->execute([$cedula]);
        return $ok ? ['success'=>true, 'message'=>'Eliminado'] : ['success'=>false, 'error'=>'No se pudo eliminar'];
    }
}
