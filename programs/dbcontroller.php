<?php
    /* ================== LYNKRTECH DATABASE CONTROLLER ================== */
    /* ============ COPYRIGHT © LYNKRTECH ALL RIGHTS RESERVED ============ */

    // $db_host      ->     SERVER ADDRESS/HOST                     |   STRING  | IP ADDRESS/URL
    // $db_username  ->     SERVER USERNAME FOR AUTH                |   STRING  |
    // $db_password  ->     SERVER PASSWORD FOR AUTH                |   STRING  |
    // $db_database  ->     DATABASE NAME                           |   STRING  |
    // $db_port      ->     PORT THE MYSQL SERVER IS RUNNING ON     |   INT     | DEFAULT: 3306

    // AUTHENTICATION DETAILS
    $db_host = "localhost"; // MYSQL SERVER HOST
    $db_username = "root"; // MYSQL SERVER USERNAME
    $db_password = ""; // MYSQL SERVER PASSWORD
    $db_database = "LYNKRTECH"; // MYSQL DATABASE
    $db_port = 3306; // MYSQL SERVER PORT

    function get_connection_object() {
        global $db_host, $db_username, $db_password, $db_database;
        $con = new mysqli($db_host, $db_username, $db_password, $db_database);
        if($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
            return FALSE;
        }
        return $con;
    }

    function runQuery($runQuery) {
        global $db_host, $db_username, $db_password, $db_database;
        // CREATE THE CONNECTION
        $con = new mysqli($db_host, $db_username, $db_password, $db_database);
        if($con->connect_error) {
            // ERROR CONNECTING TO SERVER
            die("Connection failed: " . $con->connect_error);
        }
        if($con->query($runQuery) === TRUE) {
            // SQL QUERY EXECUTED SUCCESSFULLY, RETURNING TRUE AND CLOSING CONNECTION.
            #echo "QUERY EXECUTED SUCCESSFULLY!";
            $con->close();
            return TRUE;
        } else {
            echo $con->error; // SHOW ERROR INFO, COMMENTED BY DEFAULT
            $con->close();
            // SQL QUERY NOT RUN, RETURN FALSE AND CLOSE CONNECTION.
            return FALSE;
        }
    }

    function row_count($query) {
        global $db_host, $db_username, $db_password, $db_database;
        // CREATE THE CONNECTION
        $con = new mysqli($db_host, $db_username, $db_password, $db_database);
        if($con->connect_error) {
            // ERROR CONNECTING TO SERVER
            die("Connection failed: " . $con->connect_error);
        }
        $result = $con->query($query);
        if($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
        return FALSE;
    }

    function number_of_rows($query) {
        global $db_host, $db_username, $db_password, $db_database;
        // CREATE THE CONNECTION
        $con = new mysqli($db_host, $db_username, $db_password, $db_database);
        if($con->connect_error) {
            // ERROR CONNECTING TO SERVER
            die("Connection failed: " . $con->connect_error);
        }
        $result = $con->query($query);
        if($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
        return FALSE;
    }

    function getRowCountValue($query) {
        global $db_host, $db_username, $db_password, $db_database;
        // CREATE THE CONNECTION
        $con = new mysqli($db_host, $db_username, $db_password, $db_database);
        if($con->connect_error) {
            // ERROR CONNECTING TO SERVER
            die("Connection failed: " . $con->connect_error);
        }
        $result = $con->query($query);
        $con->close();
        if($result->num_rows > 0) {
            $count = $result->fetch_assoc()["COUNT(*)"];
            return $count;
        } else {
            return false;
        }
    }

    function get_rows($query) {
        global $db_host, $db_username, $db_password, $db_database;
        // CREATE THE CONNECTION
        $con = new mysqli($db_host, $db_username, $db_password, $db_database);
        if($con->connect_error) {
            // ERROR CONNECTING TO SERVER
            die("Connection failed: " . $con->connect_error);
        }
        $result = $con->query($query);
        $con->close();
        return $result;
        return FALSE;
    }

    function get_rows_prepared($query, $params = array()) {
        global $db_host, $db_username, $db_password, $db_database;
        $con = new mysqli($db_host, $db_username, $db_password, $db_database);
        if($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $stmt = $con->prepare($query);
        if($stmt) {
            if(!empty($params)) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $con->close();
            return $result;
        } else {
            // If preparing the statement fails, handle the error
            die("Error preparing statement: " . $con->error);
        }
    }

    function get_db_datetime() {
        $get_db_datetime_query = "SELECT CURRENT_TIMESTAMP() AS DATETIME;";
        $result = get_rows($get_db_datetime_query);
        if($result->num_rows > 0) {
            $db_datetime = $result->fetch_assoc()["DATETIME"];
            return $db_datetime;
        } else {
            return false;
        }
    }
?>