<?php

namespace subdee\etsysocial;

class EtsyDb
{
    private $db;

    public function __construct()
    {
        $this->db = new \PDO('sqlite:etsysocial.sqlite3');
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->db->exec("CREATE TABLE IF NOT EXISTS listing (
                    id INTEGER PRIMARY KEY,
                    broadcasts INTEGER)");
    }

    public function isNotMaxListing($id)
    {
        $q = <<<SQL
SELECT id, MAX(broadcasts) FROM listing
SQL;
        $result = $this->db->query($q);
        return $result['id'] != $id;
    }

    public function incrementListing($id)
    {
        $q = <<<SQL
UPDATE listing SET broadcasts = broadcasts + 1 WHERE id = :id
SQL;
        $s = $this->db->prepare($q);
        $s->bindValue(':id', $id, SQLITE3_INTEGER);
        return $s->execute();
    }

} 