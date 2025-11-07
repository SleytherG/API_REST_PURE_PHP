<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/RouteAttribute.php';
require_once __DIR__ . '/../Core/Request.php';
require_once __DIR__ . '/../Util/HttpResponses.php';
require_once __DIR__ . '/../Repository/PatientRepository.php';


class PatientController extends Controller {
    private PatientRepository $patientRepository;

    public function __construct() {
        $this -> patientRepository = new PatientRepository();
    }

    #[Route('GET', '/patients')]
    public function getAllPatients(): void {
        $this -> json($this -> patientRepository -> findAll());
    }

    #[Route('GET', '/patients/{id}')]
    public function findById($id): void {
        $patient = $this -> patientRepository -> findById($id);
        $patient
            ? $this -> json($patient)
            : $this -> json(['error' => HttpResponses::$NOT_FOUND -> getMessage()], HttpResponses::$NOT_FOUND -> getCode());
    }

    #[Route('POST', '/patients')]
    public function createPatient(): void {
        try {
            $newId = $this -> patientRepository -> create($this -> input());
            $this -> json(['id' => $newId], HttpResponses::$CREATED -> getCode());
        } catch (\PDOException $e) {
            if ($e -> getCode() === '23505') {
                $this -> json(['error' => 'El DNI o el nombre ya existen. Deben ser únicos.'], HttpResponses::$CONFLICT -> getCode());
            } else {
                $this -> json(['error' => 'Error al crear paciente.'], HttpResponses::$INTERNAL_SERVER_ERROR -> getCode());
            }
        }
    }
}