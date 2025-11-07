<?php

require_once __DIR__ . '/../Core/Repository.php';
require_once __DIR__ . '/../Model/Entity/PatientEntity.php';
class PatientRepository extends Repository {
    public function __construct() {
        parent::__construct('PACIENTES', PatientEntity::class);
    }
}
