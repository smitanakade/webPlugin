<?php

/**
 * CSV Exporter bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           CSV Export
 *
 * @wordpress-plugin
 * Plugin Name:       CSV Export
 * Plugin URI:        
 * Description:       exports data base data
 * Version:           1.0.0
 * Author:            Smit kagde
 * Author URI:        www.staging.com.au
 * License:           GPL-2.0+
 * License URI:       
 * Text Domain:       Export
 * Domain Path:       /languages
 */
class CSVExport {

  /**
   * Constructor
   */
  public function __construct() {
    if (isset($_GET['report'])) {

      $csv = $this->generate_csv();
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: private", false);
      header("Content-Type: application/octet-stream");
      header("Content-Disposition: attachment; filename=\"report.csv\";");
      header("Content-Transfer-Encoding: binary");

      echo $csv;
      exit;
    }

// Add extra menu items for admins
    add_action('admin_menu', array($this, 'admin_menu'));

// Create end-points
    add_filter('query_vars', array($this, 'query_vars'));
    add_action('parse_request', array($this, 'parse_request'));
  }

  /**
   * Add extra menu items for admins
   */
  public function admin_menu() {
	  $capability = (current_user_can('author'))? 'author' : 'manage_options';

    add_menu_page('Download Report', 'Download Report', $capability, 'download_report', array($this, 'download_report'));
  }

  /**
   * Allow for custom query variables
   */
  public function query_vars($query_vars) {
    $query_vars[] = 'download_report';
    return $query_vars;
  }

  /**
   * Parse the request
   */
  public function parse_request(&$wp) {
    if (array_key_exists('download_report', $wp->query_vars)) {
      $this->download_report();
      exit;
    }
  }

  /**
   * Download report
   */
  public function download_report() {
    echo '<div class="wrap">';
    echo '<div id="icon-tools" class="icon32">
</div>';
    echo '<h2>Download Report</h2>';
    echo '<p><a href="?page=download_report&report=users">Export the Subscribers</a></p>';
  }

  /**
   * Converting data to CSV
   */
  public function generate_csv() {
    $csv_output = '';
    $table = 'aa_2r53c_productdetails';
	global $wpdb;

    $data = $wpdb->get_results("SHOW COLUMNS FROM " . $table . "");

for($i=0; $i<sizeof($data); $i++){
		  $csv_output  .= $data[$i]->Field.",";
		  }
    $csv_output .= "\n";

    $values = $wpdb->get_results("SELECT * FROM " . $table . "");
	foreach ($values as $test){

       $csv_output .= $test->productCode . ",".$test->groupCode . ",".$test->subCategory . ",".$test->APN . ",".$test->productTitle.",".$test->productDescription.",".$test->specification.",".$test->whereToBuy.",".$test->userPdf	.",".$test->brand.",".$test->status.",".$test->updatedby.",".$test->updatedOn.",".$test->approved.",".$test->replicate;
      $csv_output .= "\n";

		}
    //while ($rowr = mysql_fetch_row($values)) {
      /*foreach($values as $key= ){
	  for ($j = 0; $j < $i; $j++) {
        $csv_output .= $rowr[$j] . ",";
      }
      $csv_output .= "\n";
    }*/

/*$values = mysql_query("SELECT * FROM " . $table . "");
    while ($rowr = mysql_fetch_row($values)) {
      for ($j = 0; $j < $i; $j++) {
        $csv_output .= $rowr[$j] . ",";
      }
      $csv_output .= "\n";
    }*/


    return $csv_output;
  }

}

// Instantiate a singleton of this plugin
$csvExport = new CSVExport();