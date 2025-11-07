<?php

interface PatientService {
    public function getAllPatients(): array;
    public function findById($id): array;
    public function createPatient(array $data): array;
}