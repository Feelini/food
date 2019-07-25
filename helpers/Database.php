<?php

namespace helpers;

class Database{
    private $mysqli;
    private $query;

    public function __construct($mysqli){
        $this->mysqli = $mysqli;
        $this->query = '';
    }

    public function get_query(){
        return $this->query;
    }

    public function insert($table, $values){
        $this->query = "INSERT INTO {$table} (";
        foreach ($values as $key => $value){
            $this->query .= $key . ', ';
        }
        $this->query = substr($this->query, 0, -2);
        $this->query .= ") VALUES (";
        foreach ($values as $key => $value){
            $this->query .= $this->mysqli->real_escape_string($value) . ', ';
        }
        $this->query = substr($this->query, 0, -2);
        $this->query .= ")";
        return $this;
    }

    public function select($fields, $table){
        $this->query = "SELECT ";
        foreach ($fields as $field){
            $this->query .= $field . ', ';
        }
        $this->query = substr($this->query, 0, -2);
        $this->query .= " FROM $table";
        return $this;
    }

    public function where($condition){
        $this->query .= " WHERE ";
        foreach ($condition as $key => $item) {
            $this->query .= "$key = " . $this->mysqli->real_escape_string($item) . " AND ";
        }
        $this->query = substr($this->query, 0, -4);
        return $this;
    }

    public function left_join($table, $on){
        $this->query .= " LEFT JOIN $table ON {$on[0]} = {$on[1]}";
        return $this;
    }

    public function order_by($column){
        $this->query .= " ORDER BY $column";
        return $this;
    }

    public function limit($offset, $len = null){
        $this->query .= " LIMIT $offset";
        $this->query .= ($len) ? ", $len" : '';
        return $this;
    }

    public function count($table, $column = null, $as = null){
        $this->query = "SELECT COUNT(";
        $this->query .= ($column) ? $column . ")" : '*)';
        $this->query .= ($as) ? " AS $as" : '';
        $this->query .= " FROM $table";
        return $this;
    }

    public function delete($table, $condition){
        $this->query = "DELETE FROM {$table} WHERE ";
        foreach ($condition as $key => $item) {
            $this->query .= $key . " = " . $item . " AND ";
        }
        $this->query = substr($this->query, 0, -4);
        return $this;
    }

    public function update($table, $fields){
        $this->query = "UPDATE {$table} SET ";
        foreach ($fields as $key => $field) {
            $this->query .= $key . " = " . $field . ", ";
        }
        $this->query = substr($this->query, 0, -2);
        return $this;
    }
}