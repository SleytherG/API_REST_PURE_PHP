<?php

require_once __DIR__. '/../../Repository/PatientRepository.php';
require_once __DIR__. '/../../Util/HttpResponses.php';
require_once __DIR__. '/../PatientService.php';
class PatientServiceImpl implements PatientService {

    private PatientRepository $patientRepository;

    public function __construct() {
        $this -> patientRepository = new PatientRepository();
    }

    public function getAllPatients(): array {
        return [
            'body' => $this -> patientRepository -> findAll(),
            'status' => HttpResponses::$OK -> getCode()
        ];
    }

    public function findById($id): array {
        $patient = $this->patientRepository->findById($id);
        if ($patient) {
            return [
                'body' => $patient,
                'status' => HttpResponses::$OK->getCode()
            ];
        }
        return [
            'body' => ['error' => HttpResponses::$NOT_FOUND->getMessage()],
            'status' => HttpResponses::$NOT_FOUND->getCode()
        ];
    }

    public function createPatient(array $data): array
    {
       return [];
    }
}