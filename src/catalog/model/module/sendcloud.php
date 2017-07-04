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

    public function getIsoCode($country_id = "150") {
        $query = $this->db->query("SELECT iso_code_2 FROM " . DB_PREFIX . "country WHERE country_id = '" . $country_id . "'");
        if ($query->num_rows) {
            return $query->row["iso_code_2"];
        }
        else {
            return false;
        }
    }
}