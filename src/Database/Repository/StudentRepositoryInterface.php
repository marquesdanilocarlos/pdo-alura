<?php

namespace Alura\Pdo\Database\Repository;

use Alura\Pdo\Domain\Model\Student;
use DateTimeInterface;

interface StudentRepositoryInterface
{
    public function getById(int $id): ?Student;

    public function getAll(): array;

    public function getByBirthday(DateTimeInterface $birthDate): array;

    public function save(Student $student): bool;

    public function remove(Student $student): bool;

}