<?php
namespace comercia;

class PatchTable
{
    var $db;
    var $actions = array();
    var $name;

    function __construct($name,$db)
    {
        $this->db=$db;
        $this->name=$name;
    }

    function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    function save()
    {
        if ($this->exists()) {
            $this->update();
        } else {
            $this->create();
        }
    }

    function exists()
    {
        $prefix = DB_PREFIX;
        $query = $this->db->query("SHOW TABLES LIKE '" . $prefix . $this->name . "';");
        return $query->num_rows;
    }

    function update()
    {
        $prefix = DB_PREFIX;
        $query = "alter table `" . $prefix . $this->name . "` ";
        if (isset($this->actions["addField"])) {
            $i = 0;
            foreach ($this->actions["addField"] as $action) {
                if ($i > 0) {
                    $query .= ",";
                }
                $query .= "ADD `" . $action["name"] . "` " . $action["type"];
                $i++;
            }
        }
        $query .= "";
        $this->db->query($query);

        if (isset($this->actions["addIndex"])) {
            foreach ($this->actions["addIndex"] as $action) {
                $this->db->query("CREATE INDEX `" . $action["name"] . "` ON `" . $prefix . $this->name . "` (`" . $action["name"] . "`);");
            }
        }
    }

    function create()
    {
        $prefix = DB_PREFIX;
        $query = "create table `" . $prefix . $this->name . "` (
               `".$this->name."_id` INT NOT NULL AUTO_INCREMENT
            ";

        if (isset($this->actions["addField"])) {
            foreach ($this->actions["addField"] as $action) {
                $query .= ",`" . $action["name"] . "` " . $action["type"];
            }
        }
        $query .= ",PRIMARY KEY (".$this->name."_id))";

        $this->db->query($query);

        if (isset($this->actions["addIndex"])) {
            foreach ($this->actions["addIndex"] as $action) {
                $this->db->query("CREATE INDEX `" . $action["name"] . "` ON `" . $prefix . $this->name . "` (`" . $action["name"] . "`);");
            }
        }

        return $this;
    }

    function addField($field, $type)
    {
        $this->actions["addField"][] = array(
            "name" => $field,
            "type" => $type
        );

        return $this;
    }

    function addIndex($field)
    {
        $this->actions["addIndex"][] = array(
            "name" => $field,
        );

        return $this;
    }


}
