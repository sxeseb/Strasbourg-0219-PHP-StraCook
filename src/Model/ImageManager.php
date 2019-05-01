<?php


namespace App\Model;

class ImageManager extends AbstractManager
{
    const TABLE = 'images';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $item
     * @return int
     */
    public function insert(array $item): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`title`) VALUES (:title)");
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * @param array $item
     * @return bool
     */

    public function selectAllImages(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table i JOIN menus m on m.id = i.menus_id 
        WHERE m.id=:id;");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement ->fetchAll();
    }

    public function deleteAllImage(int $id): bool
    {
        $statement = $this->pdo->prepare("DELETE FROM images WHERE menus_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function deleteOneImage(int $id): bool
    {
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE menus_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function updateImage(array $item, $id)
    {
        $statement = $this->pdo->prepare("UPDATE $this->table i SET `img_src` = :img_src, `thumb` = :thumb
        JOIN menus m on m.id = i.menus_id  
        WHERE id=:id");
        $statement->bindValue('img_src', $item['menu_img_src'], \PDO::PARAM_STR);
        $statement->bindValue('thumb', $item['menu_thumb'], \PDO::PARAM_BOOL);
        $statement->bindvalue('id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function addImage(array $item)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`img_src`, `thumb`)
        VALUES (:img_src, :thumb)");
        $statement->bindValue('img_src', $item['menu_img_src'], \PDO::PARAM_STR);
        $statement->bindValue('thumb', $item['menu_thumb'], \PDO::PARAM_BOOL);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
