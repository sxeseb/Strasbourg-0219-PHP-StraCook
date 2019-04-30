<?php


namespace App\Model;

class ReservationManager extends AbstractManager
{

    const TABLE = 'reservation';

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
     * @param int $id
     * @return bool
     */
    public function confirm(int $id):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `status` = :status WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_STR);
        $statement->bindValue('status', true, \PDO::PARAM_BOOL);

        return $statement->execute();
    }

    public function reservationPending() :array
    {
        $statement = $this->pdo->query("SELECT r.id id, 
            date_booked date_resa, 
            SUM(o.quantity) guests, 
            concat(zip, ' ', city) place, 
            concat(lastname, ' ', firstname) client 
            FROM user u 
            JOIN reservation r ON u.id = r.user_id 
            JOIN orders o ON o.reservation_id = r.id 
            WHERE r.status != 1
            GROUP BY r.id 
            ORDER BY date_resa ASC
            ;");

        return $statement->fetchAll();
    }

    public function reservationConfirmed() :array
    {
        $statement = $this->pdo->query("SELECT r.id id, 
            status,
            date_booked date_resa,
            SUM(o.quantity) guests, 
            concat(zip, ' ', city) place, 
            concat(lastname, ' ', firstname) client 
            FROM user u 
            JOIN reservation r ON u.id = r.user_id 
            JOIN orders o ON o.reservation_id = r.id 
            
            GROUP BY r.id 
            ORDER BY date_resa ASC
            ;");

        return $statement->fetchAll();
    }

    public function reservationOrderDetails($id) :array
    {
        $statement = $this->pdo->prepare("SELECT m.name, p.cat_name categorie, price, quantity, r.date_booked 
            FROM orders o 
            JOIN reservation r ON r.id = o.reservation_id 
            JOIN menus m ON m.id = o.menus_id 
            JOIN price p on p.id = o.price_id
            WHERE r.id = :id
            ORDER BY categorie");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        if ($statement->execute()) {
            return $statement->fetchAll();
        }
    }

    public function reservationDetails(int $id) :array
    {
        $statement = $this->pdo->prepare("SELECT r.id id, 
            date_booked date_resa, 
            concat(lastname, ' ', firstname) client, 
            adress, zip, city, phone, email, status
            FROM user u 
            JOIN reservation r ON u.id = r.user_id 
            JOIN email e ON e.id = u.email_id 
            WHERE r.id = :id
            ;");

        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        if ($statement->execute()) {
            return $statement->fetch();
        }
    }
}
