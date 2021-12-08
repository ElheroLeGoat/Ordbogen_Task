<?php

namespace controllers;


/**
 * An abstract CRUD class used to as a parent to models,
 * 
 * The model will be in charge of 
 * @author bruger
 *
 */
abstract class crud
{
    protected \mysqli $db_session;
    protected int $id;
    protected string $table;
    
    function __construct($id, $table)
    {
        $this->id = $id;
        $this->table = $table;
    }
    
    public function create()
    {
        /**
         * Create method to insert new data into the database
         * 
         * @since 1.0.0
         * @return Boolean
         */
        $properties = get_object_vars($this);
        unset($properties['table'], $properties['id'], $properties['db_session']);
        
        $sql = "INSERT INTO `{$this->table}` ( ";
        $types = '';
        $values = '';
        $params = array();
        foreach ($properties as $col => $value)
        {
            $sql .= "{$col}, ";
            $values .= '?, ';
            
            $type = gettype($value);
            if      ($type == 'integer') $types .= 'i';
            else if ($type == 'double')  $types .= 'd';
            else if ($type == 'string')  $types .= 's';
            $params[] = $value;
            
        }
        
        $sql = rtrim($sql, ', ') . ") VALUES (" . rtrim($values, ', ') . ")";
       
        print($sql);
        
        $stmt = $this->db_session->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        
        return  $affected_rows > 0 ? true : false;
    }
    
    function read(array $params = Null, bool $savetoself = True)
    {
        /**
         * A method used to read a single row in the database
         * 
         * @var $params Array - An array container the search parameters in case id isn't present.
         * @var $savetoself Bool - Determine if the read should save to the class or not.
         * 
         * @since 1.0.0
         * @return $this
         * @throws \InvalidArgumentException
         */
        if ($this->id == Null && empty($params))
        {
            Throw new \InvalidArgumentException('Please make sure ID is set by either the model or in the method property');
        }
        
        if (!empty($params))
        {
            $wsql = '';
            $types = '';
            $parse = array();
            
            foreach ($params as $property => $value)
            {
                $wsql .= '`' . $property . '` = ? AND ';
                $types .= $this->getdbtype($value);
                $parse[] = $value;
            }
            
            $wsql = rtrim($wsql, 'AND ');
        }
        else
        {
            $wsql = 'id = ?';
            $parse = array($this->id);
            $types = 'i';
        }
        $stmt = $this->db_session->prepare("SELECT * FROM {$this->table} WHERE {$wsql}");
        $stmt->bind_param($types, ...$parse);
        $stmt->execute();
        $result = ($stmt->get_result())->fetch_assoc();
 
        if ($result == Null)
        {
            return False;
        }
        
        if (!$savetoself)
        {
            return True;
        }
        
        foreach ($result as $property => $value)
        {
            $this->{$property} = $value;
        }
        
        return $this;
    }
    
    public function update()
    {
        /**
         * A method that takes the classes normal parameters and updates the database.
         * 
         * @since 1.0.0
         * @return Boolean
         */
        $properties = get_object_vars($this);
        unset($properties['table'], $properties['id'], $properties['db_session']); 
        
        $sql = "UPDATE `{$this->table}` SET ";
        $types = '';
        $params = array();
        
        foreach ($properties as $col => $value)
        {
            $sql .= "`{$col}` = ?, ";
            $types .= $this->getdbtype($value);
            $params[] = $value;
        }
        
        $sql = rtrim($sql, ', ') . " WHERE `id` = ?";
        $params[] = $this->id;
        
        $stmt = $this->db_session->prepare($sql);
        $stmt->bind_param($types . 'i', ...$params);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        
        return  $affected_rows > 0 ? true : false;
    }
    
    public function delete()
    {
        /**
         * A simple method to delete current model from the database
         * 
         * @since 1.0.0
         * @return Boolean
         */
        
        $stmt = $this->db_session->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        
        return  $affected_rows > 0 ? true : false;
    }
    
    private function getdbtype($value)
    {
        $type = gettype($value);
        
        switch ($type)
        {
            case 'integer':
                return 'i';
            case 'double':
                return 'd';
            default:
                return 's';
        }
    }
}
