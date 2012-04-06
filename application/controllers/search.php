<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
  public function index() {
    $data = array( 'page' => 'search' );

    if( isset( $_GET['keyword'] ) ) {
      if( !isset($_GET['limit']) || !is_numeric($_GET['limit']) || ($_GET['limit'] = floor($_GET['limit'])) >= 20 ) {
        // the floor($_GET)'d value of $_GET['limit'] is not specified or beyond our ceiling limit (100)
        $_GET['limit'] = 20;
      }

      if( !isset($_GET['page']) || !is_numeric($_GET['page']) ) {
        $_GET['page'] = 1;
      }

      if( !isset($_GET['offset']) || !is_numeric($_GET['offset']) ) {
        // pages start at 0, but user submits 1 based value, hence we subtract one when multiplying the page # by the limit
        $_GET['offset'] = (($_GET['page'] - 1) * $_GET['limit']);
      }

      // perform keyword search and set the results in $data array
      $data['results'] = $this->api->search( $_GET );

      $catLevel = 1;
      if( isset( $_GET['cat1num'] ) ) {
        $catLevel = 2;
      }
      if( isset( $_GET['cat2num'] ) ) {
        $catLevel = 3;
      }
      if( !isset( $_GET['cat3num'] ) ) {
        $data['categories'] = $this->api->getCategories( $catLevel );
      }

      $data['query'] = $this->api->getQuery();


      // pagination setup START //
      $pagination['page'] = $_GET['page'];
      $pagination['total'] = ceil($data['results']['product_count'] / $_GET['limit']);
      // current page $_GET['page']

      // Range of pages to show 'around' the $_GET['page']
      $magneticValue = 2;

      if( ($_GET['page'] - $magneticValue) <= 0 ) {
        $pagination['start'] = 1;
      }
      else {
        $pagination['start'] = ( $_GET['page'] - $magneticValue );
      }
      $pagination['end'] = ($pagination['start'] + (2 * $magneticValue));
      if($pagination['end'] > $pagination['total']) {
        $pagination['end'] = $pagination['total'];
      }
      // generate the query string, minus the page=# value
      $pagination['qString'] = paramFilter( array( 'page', 'offset' ), false );

      $data['pagination'] = $pagination; // feed the pagination data into the template
      // pagination setup END //

    }
    $data['aff_id'] = $this->api->getAffID();
//print_r( $data );die();
    $this->load->view( 'header', $data );
    $this->load->view( 'left-menu', $data );
    $this->load->view( 'search', $data );
    $this->load->view( 'footer', $data );
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */