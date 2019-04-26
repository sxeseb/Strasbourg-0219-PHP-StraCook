<?php


namespace App\Model;

class MailManager extends AbstractManager
{
    const TABLE = 'email';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insertMail(array $item): int
    {
        $statement = $this->pdo->query("INSERT INTO $this->table (`email`) VALUES (:email)");
        $statement->bindValue('email', $item['email'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
