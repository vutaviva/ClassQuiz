<?php
class Database extends PDO
{
    public function __construct($db_type, $db_host, $db_name, $db_user, $db_pass)
    {
        $dns = $db_type . ':host=' . $db_host . ';dbname=' . $db_name;
        parent::__construct($dns,$db_user,$db_pass);
    }

    /**
     * select
     * @param string $sql :"SELECT ...FROM ...WHERE ..."
     * @param array $data :is assosciative array to store params to bind: 'placeholder'=>value
     *                      (The keys of array do not need to start with a colon)
     * @param constant $fetchMode :how the data to be fetched
     *
     */
    public function select($sql, $data = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        try {
            $sth = $this->prepare($sql);
            $sth->setFetchMode($fetchMode);

            //TODO: Kiểm tra liệu execute có thực hiện được trên số không vì mặc định là string
            $sth->execute($data);
            return $sth->fetchAll();
        } catch (PDOException $ex) {
            throw new Exception('select() in Database class has problem in ' . $ex->getMessage());
        }
    }

    /**
     * runSQL: INSERT, UPDATE, DELETE
     * @param string $sql For examaple: "INSERT INTO table (field,...) value (:placeholder,...)"
     * @param array $data array('placeholder' => 'value', ...)
     */
    public function runSQL($sql, $data)
    {
        try {
            $sth = $this->prepare($sql);
            //TODO: Kiểm tra liệu execute có thực hiện được trên số không vì mặc định là string
            $sth->execute($data);
        } catch (PDOException $ex) {
            throw new Exception('runSQL() in Database class has problem in ' . $ex->getMessage());
        }
    }

}

