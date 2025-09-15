<?php
require_once __DIR__ . '/Conexion.php';

class CrudSelect {
    public static function todos(): array {
        $pdo = Conexion::conectar();
        $st  = $pdo->query("SELECT cedula, nombre, apellido, direccion, telefono FROM estudiantes ORDER BY apellido, nombre");
        return $st->fetchAll();
    }

    public static function porCedula(string $cedula): ?array {
        $pdo = Conexion::conectar();
        $st  = $pdo->prepare("SELECT cedula, nombre, apellido, direccion, telefono FROM estudiantes WHERE cedula = ?");
        $st->execute([$cedula]);
        $row = $st->fetch();
        return $row ?: null;
    }
}
