<?php


namespace App\Model;

class MenuManager extends AbstractManager
{
    const TABLE = 'menus';

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
    public function update(array $item):bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $item['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function selectAllMenus(): array
    {
        $statement = $this->pdo->query("SELECT m.id, name, starter, main_course, dessert, img_src, description 

        FROM $this->table m JOIN images i ON m.id = i.menus_id WHERE thumb = 1;");

        return $statement = $statement->fetchAll();
    }

    public function selectAllImages(int $id): array
    {
        $statement = $this->pdo->query("SELECT * FROM images i JOIN menus m on m.id = i.menus_id where thumb = 0 ");
        return $statement = $statement->fetchAll();
    }


    public function selectOneMenus(int $id): array
    {
        $statement = $this->pdo->query("SELECT * FROM $this->table menus JOIN images ON menus.id = 
        images.menus_id where menus.id = $id");

        return $statement = $statement ->fetch();
    }

    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function deleteAllImage(int $id):bool
    {
        $statement = $this->pdo->prepare("DELETE FROM images WHERE menus_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function updateMenu(array $item):bool
    {
        $statement = $this->pdo->prepare("UPDATE $this->table SET (`name`, `starter`, `main_course`, `dessert`
, `img_src`, `description`) VALUES (:name, :starter, :main_course, :dessert, :dessert, :img_src, :description) JOIN 
menu ON menus.id = images.menus_id");
        $statement->bindValue('name', $item['name'], \PDO::PARAM_STR);
        $statement->bindValue('starter', $item['starter'], \PDO::PARAM_STR);
        $statement->bindValue('main_course', $item['main_course'], \PDO::PARAM_STR);
        $statement->bindValue('dessert', $item['dessert'], \PDO::PARAM_STR);
        $statement->bindValue('img_source', $item['img_source'], \PDO::PARAM_STR);
        $statement->bindValue('description', $item['description'], \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
