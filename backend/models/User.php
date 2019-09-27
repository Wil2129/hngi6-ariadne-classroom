<?php
declare(strict_types=1);

class User
{
    protected $uid;
    protected $name;
    protected $email;
    protected $password;
    protected $phone;
    protected $type;

    public function __construct(int $uid, string $name, string $email, string $password, string $phone = NULL)
    {
        $this->uid = $uid;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        if (!is_null($phone)){
            $this->phone = $phone;
        }
    }

    public function getId(): int
    {
        return $this->uid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
}
?>