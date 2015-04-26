<?php
/*
* SQL and PDO class
* @param instance: singleton
* @param dbh: stores PDO connect
* @param sql: used for collecting sql query
*/
class DataBase
{
    private static $instance = null;
    protected $dbh, $sql;
// try construct PDO connect
    private function __construct()
    {
        $this->sql = '';
        try
        {
            $this->dbh = new PDO("mysql:host=".HOST.";dbname=".BD,USER,PASSWORD);
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
// singleton
    static public function getInstance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
// start sql collect for INSERT 
    public function INSERT($table)
    {
        $this->sql = '';
        if ($table !== '')
        {
            $this->sql = 'INSERT INTO '.$table;
            return $this;
        }
        else
        {
            throw new Exception ("enter table name");
        }
    }
// @param keys: name of table fields
    public function keys($keys)
    {
        if($keys !== '')
        {
            $this->sql .= "($keys)";
            return $this;
        }
        else
        {
            throw new Exception ('enter field name');
        }
    }
    public function values($values)
    {
        if ($values !== '')
        {
            $this->sql .= "VALUES ($values)";
            return $this;
        }
        else
        {
            throw new Exception ("enter value for insert");
        }
    }
// start collect sql for SELECT
// @param fields: name fields in DB
    public function SELECT($fields)
    {
        $this->sql = '';
        if($fields !== '' && $fields !== '*')
        {
            $this->sql .= 'SELECT '.$fields;
            return $this;
        }
        else
        {
            throw new Exception ("no fields for select");
        }
    }
// @param table: table name 
    public function from($table)
    {
        if ($table !== '')
        {
            $this->sql .= 'FROM '.$table;
            return $this;
        }
        else
        {
            throw new Exception ("enter table name");
        }
    }
// incoming param like 'id = 5'
    public function where($where)
    {
        if($where !== '')
        {
            $this->sql .= " WHERE $where";
            return $this;
        }
        else
        {
            throw new Exception ("no value for operator where");
        }
    }
// incoming param like 'id = 5'
	public function whereAnd($and)
	{
		if($and !== '')
        {
            $this->sql .= " AND $and";
            return $this;
        }
        else
        {
            throw new Exception ("no value for operator where and");
        }
	}
    public function limit($lim)
    {
        if($lim !== '' && is_int($lim))
        {
            $this->sql .= 'LIMIT '.$limit;
            return $this;
        }
        else
        {
            throw new Exception ("not corect value for operator limit");
        }
    }
// start collect sql for UPDATE
// incoming param: table name
    public function UPDATE($table)
    {
        $this->sql = '';
        $this->sql .= 'UPDATE '.$table;
        return $this;
    }
    public function SET($field)
    {
        $this->sql .= ' SET '.$field.' = ? ';
        return $this;
    }
// start collect sql for DELETE
    public function DELETE($table)
    {
        $this->sql = '';
        $this->sql .= 'DELETE FROM '.$table;
        return $this;
    }
// execute prepare sql for INSERT or UPDATE
// return true or throw new exception
    public function insertUpdate($arr)
    {
        if($this->sql !== '')
        {
            $sth = $this->dbh->prepare($this->sql);
			if ($sth->execute($arr))
			{
				return true;
			}
			else
			{
				throw new Exception ('This values isset in DB');
			}
        }
        else
        {
            throw new Exception ("not corect sql for insert/update");
        }
    }
// execute prepare sql for SELECT
    public function selected()
    {
        if($this->sql !== '')
        {
            $sth = $this->dbh->prepare($this->sql);
            $sth -> execute();
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $res = array();
            $row = $sth->fetchAll();
            return $row;
        }
        else
        {
            throw new Exception ("failed");
        }
    }
// execute prepare sql for DELETE
    function deleted()
    {
        $sth = $this -> dbh -> prepare($this -> sql);
        $sth -> execute();
        return true; 
    }
// incoming param: table name
	public function inner($tb)
	{
		if(trim($tb) !== '')
		{
			$this -> sql .= 'INNER JOIN '.$tb;
			return $this;
		}
		else
		{
			throw new Exception ("not correct input for inner join");
		}
	}
// incoming param like 'table1.id = table2.id_table1'
	public function on($fields)
	{
		if(trim($fields) !== '')
		{
			$this -> sql .= 'ON '.$fields;
			return $this;
		}
		else
		{
			throw new Exception ("not correct input for ON");
		}
	}
	public function GROUP($fields)
	{
		$this -> sql .= " GROUP BY ".$fields;
		return $this;
	}
	public function left($tb)
	{
		if(trim($tb) !== '')
		{
			$this -> sql .= 'LEFT JOIN '.$tb;
			return $this;
		}
		else
		{
			throw new Exception ("not correct input for inner join");
		}
    }
    public function getLastInsertId()
    {
        return $this -> dbh -> lastInsertId();
    }
    public function order($by)
    {
        $this -> sql .= "ORDER BY $by";
        return $this;
    }
}
?>