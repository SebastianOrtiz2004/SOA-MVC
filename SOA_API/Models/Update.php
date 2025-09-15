<?php
require_once __DIR__ . '/Conexion.php';

class CrudActualizar {
    public static function actualizar(array $d): array {
        if (empty($d['cedula'])) {
            return ['success'=>false, 'error'=>'cedula es requerida'];
        }
        $pdo = Conexion::conectar();
        $st  = $pdo->prepare("
            UPDATE estudiantes
               SET nombre = ?, apellido = ?, direccion = ?, telefono = ?
             WHERE cedula = ?
        ");
        $ok = $st->execute([
            $d['nombre']   ?? null,
            $d['apellido'] ?? null,
            $d['direccion']?? null,
            $d['telefono'] ?? null,
            $d['cedula']
        ]);
        return $ok ? ['success'=>true, 'message'=>'Actualizado'] : ['success'=>false, 'error'=>'No se pudo actualizar'];
    }
}
