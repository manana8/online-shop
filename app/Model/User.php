<?php

namespace Model;
class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(int $id, string $name, string $email, string $password)
    {
//        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function create(string $name, string $email, string $password): void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public static function getAll(): array|null
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM users");
        $stmt->execute();

        $users = $stmt->fetchAll();

        if (empty($users)) {
            return null;
        }

        $arr = [];
        foreach ($users as $user) {
            $arr[] = new self($user['id'], $user['name'], $user['email'], $user['password']);
        }
        return $arr;
    }

    public static function getOneByEmail(string $email): User|null
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $email]);

        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }

        return new self($data['id'], $data['name'], $data['email'], $data['password']);
    }

    public static function getOneById(int $id): User|null
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }

        return new self($data['id'], $data['name'], $data['email'], $data['password']);
    }

    public function getId(): int
    {
        return $this->id;
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
}