<?php



class database {
    private $host,
        $username,
        $password,
        $database,
        $conn;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function init() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error)
            die('DB Connection Failed: ' . $this->conn->connect_error);
    }

    public function execute($query) {
        return $this->conn->query($query);
    }

    public function insert_id() {
        return mysqli_insert_id($this->conn); //->insert_id;
    }

    public function sanitize($variable) {
        return mysqli_real_escape_string($this->conn, addslashes( $variable ));
    }

    // create
    public function create($table, array $data) {
        $columns = implode(", ", array_keys($data));
        $__values = [];

        foreach ($data as $key => $value) {
            $__values[] = "'$value'";
        }
        $values = implode(", ", array_values($__values));

        $query = "INSERT INTO contacts ($columns)
            VALUES ($values)";

        return $this->execute($query);
    }

    // select
    public function read($table, $where = '', $limit = 20) {
        $query = "SELECT * FROM $table";
        $query .= ! empty($where) ? ' WHERE ' . $where : '';
        $query .= " LIMIT $limit";

        return $this->execute($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function single($table, $where = '') {
        $row = $this->read($table, $where);
        return ! empty($row[0]) ? $row[0] : null;
    }


    // update
    public function update($table, array $data, $where) {
        $columns = implode(", ", array_keys($data));
        $__values = [];

        foreach ($data as $col => $value) {
            $__values[] = "$col = '$value'";
        }
        $values = implode(", ", array_values($__values));

        $query = "UPDATE $table
            SET $values
            WHERE $where";
// dd($query);
        return $this->execute($query);
    }

    // delete
    public function delete($table, $where) {
        $query = "DELETE FROM $table WHERE $where";
        return $this->execute($query);
    }


}