<?php

namespace Physler\Db;

use mysqli;
use mysqli_result;
use Physler\Config;

define("EXPECT_ANYTHING", "expect anything");
define("EXPECT_SINGLE_ROW", "expect one row");
define("EXPECT_MULTIPLE_ROWS", "expect multiple rows");

/**
 * Simple Sql Database Client made for PHP 8.0
 */
class DbClient_S {
    public ?string $selected_database = NULL;

    // Simple newless method of class envoking.
    // Static function returns a new call of this class
    // when a connection is successfully made.
    function __construct(
        protected ?mysqli $connection = NULL,
        protected string $server_address,
        private string $username,
        private string $password
    ) { }

    /**
     * Initialize a connection to an SQL server
     * @param object $config
     */
    static public function Init($cfg) {
        mysqli_report(MYSQLI_REPORT_OFF);
        $conn = @mysqli_connect($cfg["serveraddr"], $cfg["username"], $cfg["password"]);

        if ( !$conn ) {
            throw new Exception\ConnectErrorException($cfg["serveraddr"], mysqli_connect_error());
        }

        return new DbClient_S($conn, $cfg["serveraddr"], $cfg["username"], $cfg["password"]);
    }

    static public function Default() {
        $db = DbClient_S::Init([
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
     * @throws \EMP\Db\Exception\QueryErrorException if the client fails to grab the database
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
     * @throws \EMP\Db\Exception\QueryErrorException if the client fails to pass a query through.
     */    
    public function Query($sql, $args = []) {
        $sargs = [];
        for ($i=0; $i < count($args); $i++) { 
            array_push($sargs, $this->connection->real_escape_string($args[$i]));            
        }

        $sql = sprintf($sql, ...$sargs);


        $result = $this->connection->query($sql);

        if ( $this->connection->error ) {
            throw new Exception\QueryErrorException($this->server_address, $this->connection->error);
        }

        return $result;
    }


    /**
     * Make and post an SQL query to the connected
     * database and output the results into an
     * object-oriented output
     *
     * @param string $sql
     * @return array|object
     */
    public function QueryJson($sql, $args = [], $array = false) {
        $results = $this->Query($sql, $args)->fetch_all(MYSQLI_ASSOC);
        if ($array) return $results;
        
        $restable = [];
        for ($i=0; $i < count( $results ); $i++) { 
            array_push($restable, (object)$results[$i]);
        }
        return $restable;
    }

    protected function ColumnData($table) {
        $db = DbClient_S::Default();

        // $column_query = $db->Query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='{$this->selected_database}' AND `TABLE_NAME`='{$table}';");

        $columns = [];
        // for ($i=0; $i < $column_query->num_rows; $i++) { 
        //     array_push($columns, $column_query->fetch_row()[0]);            
        // }

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