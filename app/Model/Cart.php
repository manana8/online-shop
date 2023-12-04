<?php

//namespace Model;
class Cart extends Model
{
    private int $id;
    private string $name;
    private int $userId;

    public function __construct(int $id, string $name, string $userId)
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
    }
    public static function getOneByUserId(int $userId): Cart|null
    {
        $stmt = self::getPDO()->prepare("SELECT id FROM carts WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return null;
        }

        return new self($data['id'], $data['name'], $data['user_id']);
    }

    public static function create(int $userId, string $name = null): void
    {
        if ($name === null) {
            $name = "cart_$userId";
        }
        $stmt = $this->pdo->prepare("INSERT INTO carts (name, user_id) VALUES (:name, :user_id)");
        $stmt->execute(['name' => $name, 'user_id' => $userId]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}