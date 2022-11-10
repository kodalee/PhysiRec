<?php

namespace Physler\Db;

use mysqli;
use mysqli_result;
use mysqli_sql_exception;
use Physler\Config;

define("EXPECT_ANYTHING", "expect anything");
define("EXPECT_SINGLE_ROW", "expect one row");
define("EXPECT_MULTIPLE_ROWS", "expect multiple rows");

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

    /** @var string */
    public $selected_database = NULL;

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

    static public function Default() {
        $db = DbClient::Init([
            "serveraddr" => Config::MYSQL_ADDRESS,
            "username" => Config::MYSQL_USERNAME,
            "password" => Config::MYSQL_PASSWORD
        ])->SelectDb(Config::MYSQL_DATABASE);

        return $db;        
    }

    /**
     * Select a database on the SQL server
     * @param string $database_name The name of the database
     * @return 
     * @throws \Physler\Db\Exception\QueryErrorException if the client fails to grab the database
     */
    public function SelectDb($database_name) {
        $this->connection->select_db($database_name);
        $this->selected_database = $database_name;
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

    protected function ColumnData($table) {
        $db = DbClient::Default();

        $column_query = $db->Query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='{$this->selected_database}' AND `TABLE_NAME`='{$table}';");

        $columns = [];
        for ($i=0; $i < $column_query->num_rows; $i++) { 
            array_push($columns, $column_query->fetch_row()[0]);            
        }

        return $columns;
    }

    /**
     * Handle an SQL result
     * @param mysqli_result $sql_response
     * @param string $table_schema
     * @param EXPECT_ANYTHING|EXPECT_SINGLE_ROW|EXPECT_MULTIPLE_ROWS $expecting
     */
    public function Handle($sql_response, $table_schema, $expecting = EXPECT_ANYTHING) {
        if ($sql_response->num_rows == 0) {
            return null;
        }

        if ($sql_response->num_rows == 1) {
            if (!IN_ARRAY($expecting, [EXPECT_SINGLE_ROW, EXPECT_ANYTHING])) {
                throw new Exception\FailedExpectationException($expecting);
            }

            $ordered_row = $sql_response->fetch_row();
            
            $row = [];
            $column_data = $this->ColumnData($table_schema);

            for ($idx=0; $idx < COUNT( $column_data ); $idx++) { 
                $row[$column_data[$idx]] = $ordered_row[$idx];
            }

            return (object) $row;
        }
        else {
            if (!IN_ARRAY($expecting, [EXPECT_ANYTHING, EXPECT_MULTIPLE_ROWS])) {
                throw new Exception\FailedExpectationException($expecting);
            }

            $rows = [];
            for ($i=0; $i < $sql_response->num_rows; $i++) { 
                $ordered_row = $sql_response->fetch_row();
            
                $obj = [];
                $column_data = $this->ColumnData($table_schema);
    
                for ($idx=0; $idx < COUNT( $column_data ); $idx++) { 
                    $obj[$column_data[$idx]] = $ordered_row[$idx];
                }
    
                array_push($rows, $obj);
            }

            return (object) $rows;
        }
    } 
}