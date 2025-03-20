<?php
class SQLQuery {
    protected $_dbHandle;
    protected $_result;
    protected $_table;
    /** Connects to database **/
    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = new mysqli($address, $account, $pwd, $name);
        // Check connection
        if ($this->_dbHandle->connect_error) {
            return 0;
        }
        return 1;
    }
    /** Disconnects from database **/
    function disconnect() {
        if ($this->_dbHandle) {
            $this->_dbHandle->close();
            return 1;
        } else {
            return 0;
        }
    }
    function selectAll() {
        $query = 'SELECT * FROM `' . $this->_table . '`';
        return $this->query($query);


    }
    function select($id) {
        $query = 'SELECT * FROM `' . $this->_table . '` WHERE `id` = ?';
        return $this->query($query, 1, [$id]);
    }
    /** Custom SQL Query **/
    function query($query, $singleResult = 0, $params = []) {
        if ($stmt = $this->_dbHandle->prepare($query)) {
            // Bind parameters if any
            if (count($params) > 0) {
                // Assuming the first parameter is a string for simplicity, adjust for types if needed
                $types = str_repeat('s', count($params)); // Change to 'i' for integers, etc.
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $this->_result = $stmt->get_result();
            if (preg_match("/select/i", $query)) {
                $result = array();
                $table = array();
                $field = array();
                $tempResults = array();
                $numOfFields = $this->_result->field_count;
                while ($row = $this->_result->fetch_assoc()) {
                    foreach ($row as $field => $value) {
                        $table[$field] = $field;
                        $tempResults[$field] = $value;
                    }
                    if ($singleResult == 1) {
                        return $tempResults;
                    }
                    array_push($result, $tempResults);
                }
                return $result;
            }
        }
        return [];
    }
    /** Get number of rows **/
    function getNumRows() {
        return $this->_result->num_rows;
    }
    /** Free resources allocated by a query **/
    function freeResult() {
        if ($this->_result) {
            $this->_result->free();
        }
    }
    /** Get error string **/
    function getError() {
        return $this->_dbHandle->error;
    }
}