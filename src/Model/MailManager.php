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

    public function insertMails(): array
    {
        $statement = $this->pdo->query("INSERT INTO $this->table (`email`) VALUES (:email)");

        return $statement = $statement ->fetchAll();
    }
}
