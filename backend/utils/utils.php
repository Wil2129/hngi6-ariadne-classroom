<?php
declare(strict_types=1);
require_once "database.php";
require_once(__DIR__.'/../models/User.php');
require_once(__DIR__.'/../models/Teacher.php');
require_once(__DIR__.'/../models/Student.php');
require_once(__DIR__.'/../models/Classroom.php');
require_once(__DIR__.'/../models/Item.php');

function createClassroom(Teacher &$teacher, string $name, string $category = null, string $level = null, string $description = NULL): bool
{
    $teacherId = $teacher->getId();
    try {
        $stmt = $GLOBALS['db']->prepare("INSERT INTO classrooms (teacher_id, name, category, level, description) VALUES (:teacher_id, :name, :category, :level, :description)");
        $stmt->execute(array(':teacher_id' => $teacherId, ':name' => $name, ':category' => $category, ':level' => $level, ':description' => $description));

        $id = (int) $GLOBALS['db']->lastInsertId();
        $teacher->createClassroom($id, $name, $category, $level, $description);

        return TRUE;
    } catch (PDOException $e) {
        echo "Teacher $teacherId could not create classroom $name: " . $e->getMessage();
        return FALSE;
    }
}

function addItemToClassroom(Teacher &$teacher, Classroom &$classroom, string $title, string $content = NULL, string $filesUrl = NULL): bool
{
    $teacherId = $teacher->getId();
    $classroomId = $classroom->getId();
    try {
        $stmt = $GLOBALS['db']->prepare("INSERT INTO items (classroom_id, teacher_id, title, content, files_url) VALUES (:classroom_id, :teacher_id, :title, :content, :files_url)");
        $stmt->execute(array(':classroom_id' => $classroomId, ':teacher_id' => $teacherId, ':title' => $title, ':content' => $content, ':files_url' => $filesUrl));

        $id = (int) $GLOBALS['db']->lastInsertId();
        $teacher->addItemToClassroom($id,  $classroom, $title, $content, $filesUrl);

        return TRUE;
    } catch (PDOException $e) {
        echo "Teacher $teacherId could not create classroom $name: " . $e->getMessage();
        return FALSE;
    }
}

function registerStudentToClassroom(Classroom &$classroom, Student &$student): bool
{
    $classroomId = $classroom->getId();
    $teacherId = $classroom->getTeacherId();
    $studentId = $student->getId();
    
    try {
        $stmt = $GLOBALS['db']->prepare("INSERT INTO classrooms_have_students (classroom_id, teacher_id, student_id) VALUES (:classroom_id, :teacher_id, :student_id)");
        $stmt->execute(array(':classroom_id' => $classroomId, ':teacher_id' => $teacherId, ':student_id' => $studentId));

        $student->registerToClassroom($classroom);
        
        return TRUE;
    } catch (PDOException $e) {
        echo "Could not register student $studentId to classroom $classroomId: " . $e->getMessage();
        return FALSE;
    }
}

function getClassroom(string $classroomId): ?Classroom
{
    try {
        $stmt = $GLOBALS['db']->prepare("SELECT * FROM classrooms WHERE classroom_id = :classroom_id");
        $stmt->execute(array(':classroom_id' => $classroomId));

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            return new Classroom((int) $row['classroom_id'], $row['teacher_id'], $row['name'], $row['category'], $row['level'], $row['description']);
        }

        return NULL;
    } catch (PDOException $e) {
        echo "Could not sign in user: " . $e->getMessage();

        return NULL;
    }
}

function cast($object, $className) 
{ 
    return unserialize(sprintf('O:%d:"%s"%s', strlen($className), $className, strstr(strstr(serialize($object), '"'), ':'))); 
} 
?>