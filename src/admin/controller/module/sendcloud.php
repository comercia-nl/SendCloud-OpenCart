<?php
require_once(DIR_SYSTEM . "sendcloud/sendcloud_api.php");
require_once(DIR_SYSTEM . "comercia/util.php");

use comercia\Util;

class ControllerModuleSendcloud extends Controller
{

    private $error = array();

    public function index()
    {
        //load the language data
        $data = array();
        Util::load()->language("module/sendcloud", $data);
        $model = Util::load()->model("module/sendcloud");

        Util::breadcrumb($data)
            ->add("text_home", "common/home")
            ->add("settings_title", "module/sendcloud");

        //handle the form when finished
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->request->post['sendcloud_automate'] = (int)$this->request->post['sendcloud_automate'];
            Util::config()->set('sendcloud', $this->request->post);
            // OC3 Compatibility
            $shipping_settings = array();
            foreach ($this->request->post as $key => $value) {
                $shipping_settings['shipping_' . $key] = $value;
            }
            Util::config()->set('shipping_sendcloud', $shipping_settings);

            Util::session()->success = $data['msg_settings_saved'];
            Util::response()->redirect(Util::route()->extension());
        }

        //prepare some information for the form
        $statuses = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'order_status');
        $data['statuses'] = $statuses->rows;

        $formFields = array("sendcloud_automate", "sendcloud_api_key", "sendcloud_api_secret", "sendcloud_address2_as_housenumber",  //basic information
            "sendcloud_sort_order", "sendcloud_status", "sendcloud_tax_class_id","sendcloud_locationpicker"
        );

        $taxClasses = Util::load()->model("localisation/tax_class")->getTaxClasses();

        //place the prepared data into the form
        $form = Util::form($data)
            ->fillFromSessionClear("error_warning", "success")
            ->fillFromPost($formFields)
            ->fillFromConfig($formFields)
            ->fillSelectboxOptions("tax_classes", Util::arrayHelper()->keyValuePairs($taxClasses, "title", "tax_class_id"));

        //handle document related things
        Util::document()->setTitle(Util::language()->heading_title);

        //create links
        $data['form_action'] = Util::url()->link('module/sendcloud');
        $data['cancel'] = Util::url()->link(Util::route()->extension());
        $data['url_patch'] = Util::url()->link('module/sendcloud/patch');
        $data["url_update_tracking"] = Util::url()->link('module/sendcloud/updateTrackingCodes');
        $data["url_api_tracking"] = Util::url()->catalog('api/sendcloud/updateTrackingCodes');
        $data['url_toggle_shipping'] = Util::url()->link("module/sendcloud/toggleShipping");

        //create a response
        Util::response()->view("module/sendcloud.tpl", $data);
    }

    function patch()
    {
        $this->runPatch();
        Util::response()->redirect("module/sendcloud/index");
    }

    public function install()
    {
        $this->runPatch();
    }

    private function runPatch()
    {
        Util::patch()->runPatches(
            array(
                "tracking" => function () {
                    Util::patch()->table("order")
                        ->addField("sendcloud_tracking", "varchar(250)")
                        ->addField("sendcloud_id", "int")
                        ->update();
                },
                "spId" => function () {
                    Util::patch()->table("order")
                        ->addField("sendcloud_sp_id", "varchar(250)")
                        ->update();
                }
            )
            , __FILE__
        );
    }

    function updateTrackingCodes()
    {
        $sendcloud_settings = Util::config()->getGroup('sendcloud');
        Util::load()->language("module/sendcloud");

        if (!empty($sendcloud_settings['sendcloud_api_key']) && !empty($sendcloud_settings['sendcloud_api_secret'])) {
            $api = new SendcloudApi('live', $sendcloud_settings['sendcloud_api_key'], $sendcloud_settings['sendcloud_api_secret']);
        }

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE sendcloud_id > 0 && (sendcloud_tracking IS NULL || sendcloud_tracking='')");
        foreach ($query->rows as $row) {
            $parcel = $api->parcels->get($row["sendcloud_id"]);
            if ($parcel["tracking_number"]) {
                $this->db->query("UPDATE  `" . DB_PREFIX . "order` SET sendcloud_tracking='" . $parcel["tracking_number"] . "' WHERE order_id='" . $row["order_id"] . "'");
            }
        }

        Util::response()->redirect("module/sendcloud/index");
    }

    function getCarriers($enabled = 0)
    {
        $sendcloud_settings = Util::config()->getGroup('sendcloud');
        Util::load()->language("module/sendcloud");

        if (!empty($sendcloud_settings['sendcloud_api_key']) && !empty($sendcloud_settings['sendcloud_api_secret']) && $enabled > 0) {
            $api = new SendcloudApi('live', $sendcloud_settings['sendcloud_api_key'], $sendcloud_settings['sendcloud_api_secret']);
            $carriersArray = [];
            $shipping_methods = $api->shipping_methods->get();
            foreach ($shipping_methods as $shipping_method) {
                if ($shipping_method['carrier'] != "sendcloud") {
                    if (!in_array($shipping_method['carrier'], $carriersArray)) {
                        $carriersArray[] = $shipping_method['carrier'];
                    }
                }
            }

            if (!empty($carriersArray)) {
                return implode(',', $carriersArray);
            } else {
                return '';
            }
        }
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', Util::route()->extension())) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function bulk()
    {
        $sendcloud_settings = Util::config()->getGroup('sendcloud');
        $order_error_ids = '';
        Util::load()->language("module/sendcloud");

        if (!empty($sendcloud_settings['sendcloud_api_key']) && !empty($sendcloud_settings['sendcloud_api_secret'])) {
            $api = new SendcloudApi('live', $sendcloud_settings['sendcloud_api_key'], $sendcloud_settings['sendcloud_api_secret']);
        } else {
            $this->showErrorMessage($this->language->get('msg_no_api_settings'));
        }

        if (!Util::request()->post()->selected) {
            $message = $this->language->get('error_no_orders');
            $this->showErrorMessage($message);
        }
        $selected = Util::request()->post()->selected;
        $order_model = Util::load()->model("sale/order");

        $orders = Array();
        $errors = Array();
        $errors['no_shipping_details'] = Array();
        $errors['no_shipping_method'] = Array();

        foreach ($selected as $key => $s) {
            $order = $order_model->getOrder($s);
            if ($order['shipping_iso_code_2'] == "") {
                $errors['no_shipping_details'][] = $order['order_id'];
            }
        }

        if (!empty($errors['no_shipping_details'])) {

            $order_error_ids = implode(', ', $errors['no_shipping_details']);
            $message = Util::language()->msg_order_no_shipping . " " . $order_error_ids;
            $this->showErrorMessage($message);
            Util::response()->redirect("sale/order");
        }

        // TODO: refactor code below and remove comments when confident with changes
// Commented out to track for possible short future reference. Fixing COMDEVNL-490 asap now.
//        $shipping_methods = $api->shipping_methods->get();
        foreach ($selected as $key => $s) {
            $order = $order_model->getOrder($s);
            $orders[] = $order;
//            $shipment_id = $this->getSuitableCountry($shipping_methods, $order);
//
//            if ($shipment_id) {
//                $order['sendcloud_shipment_id'] = $shipment_id;
//                $orders[] = $order;
//            } else {
//                $errors['no_shipping_method'][] = $order['order_id'];
//            }
        }

        if (!empty($errors['no_shipping_method'])) {

            $order_error_ids = implode(', ', $errors['no_shipping_method']);
            $message = Util::language()->msg_process_orders . " " . $order_error_ids;

            $this->showErrorMessage($message);
        }

        foreach ($orders as $order) {
            $spId = $this->db->query("SELECT sendcloud_sp_id FROM `" . DB_PREFIX . "order` WHERE order_id = '" . $order['order_id'] . "'")->row['sendcloud_sp_id'];

            try {
                $newParcel = array(
                    'name' => $order['shipping_firstname'] . ' ' . $order['shipping_lastname'],
                    'company_name' => $order['shipping_company'],
                    'address' => ($sendcloud_settings['sendcloud_address2_as_housenumber'] ? $order['shipping_address_1'] . ' ' . $order['shipping_address_2'] : $order['shipping_address_1']),
                    'address_2' => ($sendcloud_settings['sendcloud_address2_as_housenumber'] ? '' : $order['shipping_address_2']),
                    'city' => $order['shipping_city'],
                    'postal_code' => $order['shipping_postcode'],
                    'requestShipment' => false,
                    'email' => $order['email'],
                    'telephone' => $order['telephone'],
                    'country' => $order['shipping_iso_code_2'],
                    'order_number' => $order['order_id']
                );
                $productData = array();
                $orderProducts = $order_model->getOrderProducts($order['order_id']);
                foreach($orderProducts as $product) {
                    $weight = ($product['quantity'] * $this->getProductDetails($product['product_id'])['weight'] > 0.001) ? $product['quantity'] * $this->getProductDetails($product['product_id'])['weight'] : 0.001;

                    $productData[] = array(
                    'description' => $product['name'],
                    'quantity'    => $product['quantity'],
                    'weight'      => $weight,
                    'sku'         => $this->getProductDetails($product['product_id'])['sku'],
                    'value'       => number_format($product['total'], 2, '.', '')
                );
                }
                
                $newParcel += ['parcel_items' => $productData];

                if (!empty($spId) && strtolower($spId) != "null") {
                    $newParcel += ['to_service_point' => $spId];
                }

                $shippingCode = $order["shipping_code"];
                if (substr($shippingCode, 0, strlen("sendcloud")) == "sendcloud") {
                    $methods = $api->shipping_methods->get();
                    foreach ($methods as $method) {
                        if ("sendcloud." . $method["id"] == $shippingCode) {
                            $newParcel["shipment"] = $method;
                            break;
                        }
                    }
                }

                $parcel = $api->parcels->create($newParcel);
                $this->db->query("UPDATE `" . DB_PREFIX . "order` SET sendcloud_id='" . $parcel["id"] . "'  WHERE order_id = '" . (int)$order['order_id'] . "'");
            } catch (SendCloudApiException $exception) {
                // TODO: Validate before transporting instead of catching the API errors.
                $message = $this->language->get('msg_process_orders') . " " . $order_error_ids . $this->language->get('msg_api_error_reason') . $exception->message . '.';
                $this->showErrorMessage($message);
            }

            if ($sendcloud_settings['sendcloud_automate'] !== 0) {
                $this->updateOrderStatus($order);
            }
        }

        Util::session()->success = Util::language()->msg_success;
        Util::response()->redirect("sale/order");
    }

    private function updateOrderStatus($order)
    {
        $order_id = $order['order_id'];
        $sendcloud_settings = util::config()->getGroup('sendcloud');
        $order_status_id = $sendcloud_settings['sendcloud_automate'];
        $notify = false;
        $comment = nl2br($this->language->get('log_message'));
        $date_added = date($this->language->get('date_format_short'));

        if ($order_status_id) {
            // Queries Borrowed from /catalog/model/checkout/order.php
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
            $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
        }
    }

    private function showErrorMessage($message)
    {
        // FIXME: Hack to show error message.
        $this->session->data['success'] = "<span class='alert alert-danger' style='width:100%; width: calc(100% + 22px); float:left; position:relative; top:-29px; left:-11px;'>
		<i class='fa fa-exclamation-circle'></i> " . $message . "</span>";
        Util::response()->redirect("sale/order");
    }

    private function getSuitableCountry($shipping_methods, $order)
    {

        foreach ($shipping_methods as $sm) {
            if ($sm['id'] == 8) {
                // Workaround: Brievenpost is not suitable for transport scenarios.
                // It does not allow you to change to a correct parcel shipping method in the SendCloud panel.
                continue;
            }
            foreach ($sm['countries'] as $country) {
                if ($country['iso_2'] == $order['shipping_iso_code_2']) {
                    return $sm['id'];
                }
            }
        }
        return false;
    }

    private function getProductDetails($productId) {
        $product_model = Util::load()->model("catalog/product");
        $productDetail = $product_model->getProduct($productId);

        return [
            'weight' => $productDetail['weight'],
            'sku'    => $productDetail['sku']
        ];
    }

}

?>