<?php

class SQLQuery {
    protected $_dbHandle;
    protected $_result;

    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = new mysqli($address, $account, $pwd, $name);
        if ($this->_dbHandle->connect_error) {
            return 0;
        }
        else {
            return 1;
        }
    }

    function disconnect() {
        if ($this->_dbHandle->close()) {
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
        $query = 'SELECT * FROM `' . $this->_table . '` WHERE `id` = \'' . $this->_dbHandle->real_escape_string($id) . '\'';
        return $this->query($query, 1);
    }

    function query($query, $singleResult = 0) {
        $this->_result = $this->_dbHandle->query($query);

        if ($this->_result) {
            if (preg_match("/select/i", $query)) {
                $result = array();
                $table = array();
                $field = array();
                $tempResults = array();
                $numOfFields = $this->_result->field_count;
                for ($i = 0; $i < $numOfFields; ++$i) {
                    array_push($table, $this->_result->fetch_field($i)->table);
                    array_push($field, $this->_result->fetch_field($i)->name);
                }

                while ($row = $this->_result->fetch_assoc()) {
                    for ($i = 0; $i < $numOfFields; ++$i) {
                        $table[$i] = trim(ucfirst($table[$i]), "s");
                        $tempResults[$table[$i]][$field[$i]] = $row[$field[$i]];
                    }
                    if ($singleResult == 1) {
                        $this->_result->free();
                        return $tempResults;
                    }
                    array_push($result, $tempResults);
                }
                $this->_result->free();
                return $result;
            }
        }
    }

    function getNumRows() {
        return $this->_result->num_rows;
    }

    function freeResult() {
        $this->_result->free();
    }

    function getError() {
        return $this->_dbHandle->error;
    }
}