<?php

class ModelModuleSendcloud extends Model
{
    public function getCountryId($isoCode = "NL") {
        $query = $this->db->query("SELECT country_id FROM " . DB_PREFIX . "country WHERE iso_code_2 = '" . $isoCode . "'");
        if ($query->num_rows) {
            return $query->row["country_id"];
        }
        else {
            return false;
        }
    }
}