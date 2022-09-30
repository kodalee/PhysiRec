<?php

namespace Physler\Db;

use mysqli;
use mysqli_result;
use mysqli_sql_exception;

/**
 * Simple Sql Database Client
 */
class DbClient {
    /** @var mysqli */
    protected $connection = NULL;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    protected $server_address;

    // Simple newless method of class envoking.
    // Static function returns a new call of this class
    // when a connection is successfully made.
    function __construct($sql_connection, $server_address, $username, $password) {
        $this->connection = $sql_connection;

        $this->username = $username;
        $this->password = $password;
        
        $this->server_address = $server_address;
    }

    /**
     * Initialize a connection to an SQL server
     * @param object $config
     */
    static public function Init($config) {
        mysqli_report(MYSQLI_REPORT_OFF);
        $conn = @mysqli_connect($config["serveraddr"], $config["username"], $config["password"]);

        if ( !$conn ) {
            throw new Exception\ConnectErrorException($config["serveraddr"], mysqli_connect_error());
        }

        return new DbClient($conn, $config["serveraddr"], $config["username"], $config["password"]);
    }

    /**
     * Select a database on the SQL server
     * @param string $database_name The name of the database
     * @return 
     * @throws \Physler\Db\Exception\QueryErrorException if the client fails to grab the database
     */
    public function SelectDb($database_name) {
        $this->connection->select_db($database_name);
        return $this;
    }

    /**
     * Make and post an SQL query to the connected database
     * @param string $sql The SQL query to input.
     * @return mysqli_result Result data
     * @throws \Physler\Db\Exception\QueryErrorException if the client fails to pass a query through.
     */    
    public function Query($sql) {
        $result = $this->connection->query($sql);

        if ( $this->connection->error ) {
            throw new Exception\QueryErrorException($this->server_address, $this->connection->error);
        }

        return $result;
    }
}