<?php
declare(strict_types=1);
require_once "User.php";
require_once "Classroom.php";
require_once "Item.php";

class Student extends User
{
    const TYPE = 'student';

    private $type = self::TYPE;
    private $studentId;
    private $classrooms;

    public function __construct(int $studentId, string $name, string $email, string $password, string $phone = NULL)
    {
        parent::__construct($studentId, $name, $email, $password, $phone);
        $this->studentId = $this->uid;
        $this->type = self::TYPE;
        $this->classrooms = array();
    }

    public function getId(): int
    {
        return $this->studentId;
    }

    public function getClassrooms(): array
    {
        return $this->classrooms;
    }

    public function registerToClassroom(Classroom $classroom): void
    {
        $this->classrooms[] = $classroom;
        $classroom->registerStudent($this);
    }

    public function getItems(Classroom $classroom): array
    {
        if (in_array($classroom, $this->classrooms)) {
            return $classroom->items;
        }
    }
}
?>