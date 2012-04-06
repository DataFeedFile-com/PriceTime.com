<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
  public function index( ) {
    die('nothing to see here');
  }

  public function compare( $core_num ) {
    $data = array( 'page' => 'product' );

    
    $data['aff_id'] = $this->api->getAffID();
    $data['core_num'] = $core_num;
    $data['product_details'] = $this->api->product( $core_num );
    $data['query'] = $this->api->getQuery();

    $this->load->view( 'header', $data );
    $this->load->view( 'product', $data );
    $this->load->view( 'footer', $data );

  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */