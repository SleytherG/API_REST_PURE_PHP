<?php


class PatientEntity {

    public ?int $id = null;
    public string $dni;
    public string $nombre;
    public ?string $direccion = null;
    public ?string $codigopostal = null;
    public ?string $telefono = null;
    public ?string $genero = null;
    public ?string $fechanacimiento = null;
    public ?string $correo = null;

}