<?php

namespace Alura\Pdo\Domain\Model;

use DomainException;

class Student
{
    private ?int $id;
    private string $name;
    private \DateTimeInterface $birthDate;

    /**
     * @var Phone[] $phones
     */
    private array $phones = [];

    public function __construct(?int $id, string $name, \DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function getAge(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }

    public function setId(int $id): void
    {
        if ($this->id) {
            throw new DomainException("Este aluno já possui ID definido.");
        }

        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones[] = $phone;
    }

    /**
     * @return Phone[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

}
