<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2015 osCommerce
  
  Author: Cluster Solutions

  Released under the GNU General Public License
*/

  class ht_price_display {
    var $code = 'ht_price_display';
    var $group = 'footer_scripts';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function ht_price_display() {
      $this->title = MODULE_HEADER_TAGS_PRICE_DISPLAY_TITLE;
      $this->description = MODULE_HEADER_TAGS_PRICE_DISPLAY_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_PRICE_DISPLAY_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_PRICE_DISPLAY_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_PRICE_DISPLAY_STATUS == 'True');
      }
    }

    function execute() {
      global $oscTemplate, $currencies;
      $currencies = new currencies_mod();
      $oscTemplate->addBlock('<script>$(".remove").closest(".btn-group").remove()</script>', $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_HEADER_TAGS_PRICE_DISPLAY_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Price Display Control', 'MODULE_HEADER_TAGS_PRICE_DISPLAY_STATUS', 'True', 'Do you want to enable price display control for members only?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_PRICE_DISPLAY_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_HEADER_TAGS_PRICE_DISPLAY_STATUS', 'MODULE_HEADER_TAGS_PRICE_DISPLAY_SORT_ORDER');
    }

  }

  class currencies_mod extends currencies {

    public function display_price($products_price, $products_tax, $quantity = 1) {
      global $customer_id;
      if (tep_session_is_registered('customer_id') && defined(MODULE_HEADER_TAGS_PRICE_DISPLAY_STATUS) && MODULE_HEADER_TAGS_PRICE_DISPLAY_STATUS == 'True') {
        return $this->format($this->calculate_price($products_price, $products_tax, $quantity));
      } else {
        return '<div class="remove"></div>';
      }
    }

  }

?>
