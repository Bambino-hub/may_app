<?php

namespace App\Models;

use App\Core\Db;

abstract class Model
{

    protected $table;

    private $db;

    // on va de commencé on crée une fonction qui permet de preparer la requête
    public function querys(string $request, array $values = [])
    {
        // on recupère l'instance de db
        $this->db = Db::getInstance();

        // on verifie si on a les valeurs si oui on exécute 
        if ($values !== null) {
            $respons = $this->db->prepare($request);
            $respons->execute($values);
            return $respons;
        } else {
            // sinon on a une requête simple 
            return $this->db->query($request);
        }
    }

    // ici on va faire du crud,
    /**
     * function to create users
     *
     * @return void
     */
    public function create()
    {
        $field = [];
        $mak = [];
        $values = [];
        foreach ($this as $field => $value) {
            if ($value !== null && $field != 'db' && $field != 'table') {
                $field[] = $field;
                $values[] = $value;
                $mak[] = "?";
            }
        }

        // on transforme les tableaux en une chaine de caractère
        $array_field = implode(',', $field);
        $array_mak = implode(',', $mak);

        // on envoie les information a la requête
        return $this->querys('INSERT INTO ' . $this->table . '( ' . $array_field . ' ) VALUES ( ' . $array_mak . ')', $values);
    }
    // select * from annonce 

    /**
     * this function find all annoce from database
     *
     * @return void
     */
    public function findAll()
    {
        $query = $this->querys('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    /**
     * function to find annonce by critères
     *
     * @param array $fields
     * @return void
     */
    public function findBy(array $field)
    {
        // select * annonce where name = ? and id = ?
        foreach ($field as $field => $value) {
            $fields[] = "$field ?";
            $values[] = $value;

            // on transforme le tableau en une chaine de caractère
            $array_field = implode(" AND ", $fields);

            // on exécute la requete
            return $this->querys('SELECT * FROM ' . $this->table . ' WHERE ' . $array_field, $values)->fetchAll();
        }
    }

    public function findById(int $id)
    {
        return $this->querys(" SELECT * FROM $this->table WHERE id = $id ")->fetch();
    }

    /**
     * function to hydrate objet
     *
     * @param array $data
     * @return void
     */
    public function hydrate($data)
    {
        foreach ($data as $field => $value) {
            // on recupère les champs correspondant
            $setter = 'set' . ucfirst($field);

            // on verifie si le setter existe dans l'objet
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
            return $this;
        }
    }
    // update nnonce 
    public function update()
    { // update annonce set name = ? , firstname = ? where id =?
        $field = [];
        $values = [];

        // on recupère les champs et leurs valeur
        foreach ($this as $field => $value) {
            if ($value !== null && $field != 'db' && $field != 'table') {

                $fields[] = "$field ? ";
                $values[] = $value;
            }
            $array_field = implode(',', $field);
            $values[] = $this->id;
        }
        return  $this->querys('UDPDATE ' . $this->table . ' SET ' . $array_field  . 'WHERE id = ?', $values);
    }


    /**
     *  function to delete annonce 
     *
     * @param [type] $id
     * @return void
     */
    // delete
    public function delete($id)
    {
        return $this->querys("DELETE FROM  $this->table  WHERE id = ?", [$id]);
    }
}
