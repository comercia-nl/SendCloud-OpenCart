<?php

use comercia\Util;

class ControllerApiSendcloud extends Controller
{
    function __construct($registry)
    {
        parent::__construct($registry);
        require_once(DIR_SYSTEM . "/sendcloud/sendcloud_api.php");
    }

    public function updateTrackingCodes()
    {
        try {
            $sendcloud_settings = Util::config()->getGroup('sendcloud');
            Util::load()->language("module/sendcloud");

            if (!empty($sendcloud_settings['sendcloud_api_key']) && !empty($sendcloud_settings['sendcloud_api_secret'])) {
                $api = new SendcloudApi('live', $sendcloud_settings['sendcloud_api_key'], $sendcloud_settings['sendcloud_api_secret']);
            }


            $query = $this->db->query("select * from " . DB_PREFIX . "order where sendcloud_id>0 && (sendcloud_tracking IS NULL || sendcloud_tracking='')");
            foreach ($query->rows as $row) {
                $parcel = $api->parcels->get($row["sendcloud_id"]);
                if ($parcel["tracking_number"]) {
                    $this->db->query("update  " . DB_PREFIX . "order set sendcloud_tracking='" . $parcel["tracking_number"] . "' where order_id='" . $row["order_id"] . "'");
                }
            }
        } catch (Exception $ex) {
            die(json_encode(array("success" => 0, "message" => $ex->getMessage())));
        }
        echo json_encode(array("success" => 1, "message" => "Success"));
    }

    public function servicePointSelected()
    {
        try {
            if (isset($this->request->get['spId']) && $this->request->get['spId']) {
                // sets the chosen service point id for this session
                // make sure it is saved with the order on checkout
                Util::session()->spId = $this->request->get['spId'];
            }
        } catch (Exception $ex) {
            die(json_encode(array("success" => 0, "message" => $ex->getMessage())));
        }
        echo json_encode(array("success" => 1, "message" => "Success"));
    }
}