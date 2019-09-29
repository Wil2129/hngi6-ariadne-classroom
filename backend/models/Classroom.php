<?php
declare(strict_types=1);
require_once "Item.php";
require_once "Student.php";

class Classroom
{
    private $classroomId;
    private $teacherId;
    private $name;
    private $category;
    private $level;
    private $description;
    private $items;
    private $students;

    public function __construct(int $classroomId, int $teacherId, string $name, string $category = null, string $level = null, string $description = null)
    {
        $this->classroomId = $classroomId;
        $this->teacherId = $teacherId;
        $this->name = $name;
        $this->items = array();
        $this->students = array();
        if (!is_null($category)) {
            $this->category = $category;
        }
        if (!is_null($level)) {
            $this->level = $level;
        }
        if (!is_null($description)) {
            $this->description = $description;
        }
    }

    public function getId(): int
    {
        return $this->classroomId;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }
    
    public function setLevel(string $level): void
    {
        $this->level = $level;
    }
    
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function registerStudent(Student $student): void
    {
        $this->students[] = $student;
    }
}
