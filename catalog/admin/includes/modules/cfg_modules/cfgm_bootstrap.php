<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2015 osCommerce

  Released under the GNU General Public License
*/

  class cfgm_bootstrap {
    var $code = 'bootstrap';
    var $directory;
    var $language_directory = DIR_FS_CATALOG_LANGUAGES;
    var $key = 'MODULE_BOOTSTRAP_INSTALLED';
    var $title;
    var $template_integration = true;

    function cfgm_bootstrap() {
      $this->directory = DIR_FS_CATALOG_MODULES . 'bootstrap/';
      $this->title = MODULE_CFG_MODULE_BOOTSTRAP_TITLE;
    }
  }
?>
