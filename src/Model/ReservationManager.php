<?php


namespace App\Model;

class ReservationManager extends AbstractManager
{

    const TABLE = 'reservations';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $reservation, int $user_id): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (status, user_id, date_booked) VALUES (
            :status, :user_id, :date_booked)");
        $statement->bindValue(':status', false, \PDO::PARAM_BOOL);
        $statement->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $statement->bindValue(':date_booked', $reservation['date_booked'], \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }


    // Actions admin

    /**
     * @param int $id
     */
    public function decline(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param array $reservation
     * @return bool
     */
    public function confirm(array $reservation):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $reservation['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $reservation['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
