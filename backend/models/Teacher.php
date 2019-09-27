<?php
declare(strict_types=1);
require_once "User.php";
require_once "Classroom.php";
require_once "Item.php";

class Teacher extends User
{
    const TYPE = 'teacher';

    private $type = self::TYPE;
    private $teacherId;
    private $classrooms;

    public function __construct(int $teacherId, string $name, string $email, string $password, string $phone = NULL)
    {
        parent::__construct($teacherId, $name, $email, $password, $phone);
        $this->teacherId = $this->uid;
        $this->type = self::TYPE;
        $this->classrooms = array();
    }

    public function getId(): int
    {
        return $this->teacherId;
    }

    public function getClassrooms(): array
    {
        return $this->classrooms;
    }

    public function createClassroom(int $classroomId, string $name, string $description = NULL): void
    {
        $classroom = new Classroom($classroomId, $this->teacherId, $name, $description);
        $this->classrooms[] = $classroom;
    }

    public function addItemToClassroom(int $itemId, Classroom $classroom, string $title, string $content = NULL, string $filesUrl = NULL): void
    {
        if (in_array($classroom, $this->classrooms)) {
            $item = new Item($itemId, $classroom->classroomId, $this->teacherId, $title, $content, $filesUrl);
            $classroom->addItem($item);
        }
    }
}
?>