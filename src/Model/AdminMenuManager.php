<?php


namespace App\Model;

class AdminMenuManager extends AbstractManager
{
    const TABLE = 'menus';

    /*
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    /*
     * @param array $item
     * @return int
     */
    public function insert(string $name,string $starter, string $mainCourse,string $dessert, string $desc, string $url): int
    {
        $success=0;
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO menus (name,starter,main_course,dessert,description) VALUES (:name,:starter,:main_course,:dessert,:description)");
        if ($statement->execute(array('name'=>$name,'starter'=>$starter,'main_course'=>$mainCourse,'dessert'=>$dessert,'description'=>$desc))) 
        {
            $lastItemId=(int)$this->pdo->lastInsertId();
            $statement2 = $this->pdo->prepare("INSERT INTO images (menus_id,img_src) VALUES (:menus_id,:img_src)");
            if($statement->execute(array('menus_id'=>$lastItemId,'img_src'=>$url)))
            {     
                 $success=1;
            }
        
        }
        return $success;
    }


    /*
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
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
        $statement = $this->pdo->query("SELECT * FROM menus m, images i where m.id = i.menus_id");
        return $statement = $statement ->fetchAll();
    }
}
