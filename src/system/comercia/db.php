<?php
namespace comercia;

class db
{
    public function saveDataObject($table, $data, $keys = null, $structure = [], $events = [])
    {

        if(@$events["preSave"]){
            $events["preSave"]($table,$data,$keys,$structure);
        }

        if (!$keys) {
            $keys[] = $table . "_id";
        }
        $exists = $this->recordExists($table, $data, $keys);

        if ($exists) {
            $query = "UPDATE `" . DB_PREFIX . $table . "` SET ";
        } else {
            $query = "INSERT INTO `" . DB_PREFIX . $table . "` SET ";
        }

        $i = 0;
        foreach ($data as $key => $value) {
            if (!$this->columnExists($table, $key)) {
                continue;
            }
            if ($i++) {
                $query .= ",";
            }
            $query .= "`" . $key . "` = '" . $this->_db()->escape($value) . "'";
        }
        if ($exists) {
            $query .= " WHERE ";
            $query .= $this->whereForKeys($table, $data, $keys);
        }
        $this->_db()->query($query);


        if (!$exists) {
            $result = $this->_db()->getLastId();
            if (!is_array($result)) {
                $result = [$result];
            }
        }

        if ((!isset($result) || !$result) && count($keys) == 1) {
            $result = $data[$keys[0]];
        } elseif (!$result) {
            $result = [];
            foreach ($keys as $key) {
                $result[] = $data[$key];
            }
        }

        foreach ($keys as $keyNumber => $key) {
            $data[$key] = $result[$keyNumber];
        }

        if (!empty($structure)) {
            foreach ($structure as $field => $structureItem) {
                //if the refference key is in the table of newly created record.
                if (!$structureItem["ref"]) {
                    if (isset($data[$structureItem["field"]][0])) {
                        foreach ($data[$field] as &$dataItem) {
                            foreach ($structureItem["key"] as $currentTableKey => $connectedTableKey) {
                                $dataItem[$connectedTableKey] = $data[$currentTableKey];
                            }
                            $dataItem["__parent"]=$data;

                            $this->saveDataObject($structureItem["table"], $dataItem, [], $structureItem["structure"],$structureItem["events"]);
                        }
                    } else {
                        $dataItem=$data[$field];
                        $dataItem["__parent"]=$data;
                        foreach ($structureItem["key"] as $currentTableKey => $connectedTableKey) {
                            $data[$structureItem["field"]][$connectedTableKey] = $data[$currentTableKey];
                        }
                        $this->saveDataObject($structureItem["table"], $dataItem, [], $structureItem["structure"],$structureItem["events"]);
                    }

                    //if the reference is on the current table side
                } else {
                    $dataItem = $data[$field];
                    $dataItem["__parent"]=$data;
                    $structureItemKeys = [];
                    foreach ($structureItem["key"] as $currentTableKey => $connectedTableKey) {
                        $structureItemKeys[] = $connectedTableKey;
                    }
                    $saveResult = $this->saveDataObject($structureItem["table"], $dataItem, $structureItemKeys, $structureItem["structure"],$structureItem["events"]);

                    if (!is_array($saveResult) && $saveResult) {
                        $saveResult = [$saveResult];
                    }

                    $updateData = [];
                    foreach ($keys as $key) {
                        $updateData[$key] = $data[$key];
                    }

                    foreach ($saveResult as $keyNumber => $saveResultKeyOutput) {
                        $updateData[$structureItemKeys[$keyNumber]] = $saveResultKeyOutput;
                    }

                    $this->saveDataObject($table, $updateData, $keys);
                }
            }
        }
        return $result;
    }


    public function deleteDataObject($table, $data, $keys = null)
    {

        $query = "DELETE FROM `" . DB_PREFIX . $table . "` WHERE ";
        $query .= $this->whereForKeys($table, $data, $keys);
        $this->_db()->query($query);
    }

    public function recordExists($table, $data, $keys = null)
    {

        $query = "SELECT * FROM `" . DB_PREFIX . $table . "` WHERE ";
        $query .= $this->whereForKeys($table, $data, $keys);
        $query .= " LIMIT 0,1";
        $query = $this->_db()->query($query);

        return (bool)$query->num_rows;
    }

    public function columnExists($table, $column)
    {
        static $columns = [];

        if (!isset($columns[$table][$column])) {
            $query = "SHOW COLUMNS FROM `" . DB_PREFIX . $table . "` LIKE '" . $column . "'";
            $columns[$table][$column] = (bool)$this->_db()->query($query)->num_rows;
        }

        return $columns[$table][$column];
    }

    private function whereForKeys($table, $data, $keys = null)
    {
        if (!$keys) {
            $keys[] = $table . "_id";
        }
        $result = "";
        foreach ($keys as $akey => $key) {
            if ($akey > 0) {
                $result .= " && ";
            }
            $result .= " `" . $key . "` = '" . @$data[$key] . "' ";
        }

        return $result;
    }

    function escape($value)
    {
        return $this->_db()->escape($value);
    }

    private function whereForData($data)
    {
        $result = '';

        $i = 0;
        foreach ($data as $key => $value) {
            if ($i++) {
                $result .= ' && ';
            }

            $result .= "`" . $key . "` = '" . $this->_db()->escape($value) . "'";
        }

        return $result;
    }

    public function saveDataObjectArray($table, $data, $keys = null, $structure = [], $events = [])
    {
        foreach ($data as $obj) {
            $this->saveDataObject($table, $obj, $keys, $structure, $events);
        }
    }

    private function _db()
    {
        $registry = Util::registry();
        if (!$registry->has('db')) {
            $registry->set('db', new db());
        }

        return $registry->get("db");
    }

    public function select($table, $fields = [], $where = [], $structure = [], $events = [])
    {
        if (empty($fields)) {
            $fields[] = '*';
        }

        $query = "SELECT ";

        $i = 0;
        foreach ($fields as $field) {
            if ($i++) {
                $query .= ',';
            }
            $query .= $field == '*' ? $field : '`' . $field . '`';
        }


        $query .= " FROM `" . DB_PREFIX . $table . "`";

        if (!empty($where)) {
            $query .= " WHERE ";
            $query .= $this->whereForData($where);
        }

        $result = $this->_db()->query($query);

        $rows = [];
        if ($result && is_object($result)) {
            $rows = $result->rows;
            if (!empty($structure)) {
                $rows = array_map(function ($row) use ($structure) {
                    foreach ($structure as $field => $structureItem) {
                        if (@$structureItem["load_callable"]) {
                            $row[$field] = $structureItem["load_callable"]($row);
                        } else {
                            $where = [];
                            foreach ($structureItem["key"] as $currentTableKey => $connectedTableKey) {
                                $where[$connectedTableKey] = $row[$currentTableKey];
                            }

                            $result = $this->select($structureItem["table"], $structureItem["fields"], $where, $structureItem["structure"]);

                            if ($structureItem["single"]) {
                                $result = $result[0];
                            }
                            $row[$field] = $result;
                        }
                    }
                    return $row;
                }, $rows);
            }
        }

        //note: In the past there was an if statement which gave in case of 1 row result, the row itself rather than an array with 1 row. To avoid unexpected behaviour this is taken away.
        return $rows;
    }

    function reference($table, $key, $fields = [], $structure = [], $events = [])
    {
        return ["single" => true, "ref" => 1, "table" => $table, "structure" => $structure, "fields" => $fields, "key" => $key, "events" => $events];
    }

    function many($table, $key, $fields = [], $structure = [], $events = [])
    {
        return ["single" => false, "ref" => 0, "table" => $table, "structure" => $structure, "fields" => $fields, "key" => $key, "events" => $events];
    }

    function script($load = false, $save = false)
    {
        return ["load_callable" => $load, "save_callable" => $save];
    }


    public function query($query)
    {
        $result = $this->_db()->query($query);

        if ($result && is_object($result)) {
            return $result->rows;
        }

        return [];
    }
}
?>
