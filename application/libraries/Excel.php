<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
require_once APPPATH."/libraries/Bootstrap.php"; 
class Excel extends PHPSpreadsheet {
 public function __construct() {
    parent::__construct();
 }
}
