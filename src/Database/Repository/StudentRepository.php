<?php

namespace Alura\Pdo\Database\Repository;

use Alura\Pdo\Domain\Model\Phone;
use Alura\Pdo\Domain\Model\Student;
use DateTimeImmutable;
use DateTimeInterface;
use PDO;
use PDOException;

use function array_key_exists;
use function array_keys;
use function count;

class StudentRepository implements StudentRepositoryInterface
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $id): ?Student
    {
        try {
            $query = "SELECT * FROM students WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();

            return $result
                ? $this->hydrate($result, false)
                : null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAll(): array
    {
        try {
            $query = "SELECT * FROM students";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result
                ? $this->hydrate($result)
                : [];
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getByBirthday(DateTimeInterface $birthDate): array
    {
        try {
            $query = "SELECT * FROM students WHERE birth_date = :birthDate";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":birthDate", $birthDate->format("Y-m-d"), PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $this->hydrate($result);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function save(Student $student): bool
    {
        if ($student->getId()) {
            return $this->update($student);
        }

        return $this->insert($student);
    }

    public function remove(Student $student): bool
    {
        try {
            $query = "DELETE FROM students WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":id", $student->getId(), PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function insert(Student $student): bool
    {
        try {
            $query = "INSERT INTO students (name, birth_date) VALUES (:name, :birthDate) ";
            $stmt = $this->connection->prepare($query);

            $result = $stmt->execute([
                "name" => $student->getName(),
                "birthDate" => $student->getBirthDate()->format("Y-m-d")
            ]);

            if ($result) {
                $student->setId($this->connection->lastInsertId());
            }

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function update(Student $student): bool
    {
        try {
            $query = "UPDATE students SET name = :name, birth_date = :birthDate  WHERE id = :id";
            $stmt = $this->connection->prepare($query);

            return $stmt->execute([
                "id" => $student->getId(),
                "name" => $student->getName(),
                "birthDate" => $student->getBirthDate()->format("Y-m-d")
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function hydrate(array $data, bool $multiple = true): array|Student
    {
        if (!$multiple) {
            return new Student(
                $data["id"],
                $data["name"],
                new DateTimeImmutable($data["birth_date"])
            );
        }

        $hydrateData = [];

        foreach ($data as $student) {
            $hydrateData[] = new Student(
                $student["id"],
                $student["name"],
                new DateTimeImmutable($student["birth_date"])
            );
        }

        return $hydrateData;
    }

    public function getWithPhones(): array
    {
        $query = "SELECT 
                    students.id,
                    students.name,
                    students.birth_date,
                    phones.id as phone_id,
                    phones.area_code,
                    phones.number
                    FROM students
                   INNER JOIN phones on phones.student_id = students.id";

        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $students = [];

        foreach ($result as $row) {
            if (!array_key_exists($row["id"], $students)) {
                $students[$row["id"]] = new Student(
                    $row["id"],
                    $row["name"],
                    new DateTimeImmutable($row['birth_date'])
                );
            }

            $phone = new Phone(
                $row["phone_id"],
                $row["area_code"],
                $row["number"]
            );
            $students[$row["id"]]->addPhone($phone);
        }

        return $students;
    }


}