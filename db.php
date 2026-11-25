<?php
// Conexión a la base de datos SQLite
$dbPath = __DIR__ . '/dulceria.db';
$conexion = new PDO('sqlite:' . $dbPath);
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Crear la tabla solamente si no existe
$conexion->exec('CREATE TABLE IF NOT EXISTS productos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    categoria TEXT NOT NULL,
    precio REAL NOT NULL,
    imagen TEXT
)');
?>