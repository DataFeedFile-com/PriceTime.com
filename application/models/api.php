<?php
class Api extends CI_Model {
  // $dbGroup is the database definition to use when connecting, these are defined in /application/config/database.php
  var $aff_num;
  var $token;
  var $queryCache;
  var $queryNum;
  var $queryKeys;
  var $validFields;
  
  function __construct( $aff_num = 18098, $token = 'N2MzMmJlMTcyYTlkOWFhMTUxYTBhOD' ) {
    parent::__construct();

    $this->aff_num = $aff_num;
    $this->token = $token;
    $this->queryCache = array();
    $this->queryNum = -1;
  }

  private function runQuery( $url ) {
    if( isset( $this->queryCache[ $url ] ) ) {
      return $this->queryCache[ $url ];
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $json = curl_exec($ch);
    $this->queryNum++;

    $response = json_decode( $json, true );
    $this->queryCache[ $url ] = $response;
    $this->queryKeys = array_keys( $this->queryCache );

    return $this->queryCache[ $url ];
  }

  public function getAffID() {
    return $this->aff_num;
  }

  public function search( $options ) {
    if( !empty($options['keyword']) ) {
      $url = "http://www.datafeedfile.com/json/json_search.php?json_script=json_search.php&affid={$this->aff_num}&dfftoken={$this->token}";

      foreach( $options as $key => $val ) {
        $val = urlencode( $val );
        $url .= "&{$key}={$val}";
      }

      return $this->runQuery( $url );
    }
  }

  public function product( $sku ) {
    $url = "http://www.datafeedfile.com/json/json_prdt_pricecomp.php?affid={$this->aff_num}&product_sku={$sku}&dfftoken={$this->token}";
    return $this->runQuery( $url );
  }

  public function queryIndex() {
    return $this->queryNum;
  }

  public function getQuery( $index = false ) {
    return ( $index === false ? $this->queryKeys[ (count( $this->queryCache ) - 1) ] : $this->queryKeys[ $index ] );
  }

  /**
   * Function takes the cached output from the last (or an index number) search result set and returns all of the cat1, cat2, and cat3 info
   * @param int $set integer index of query run
   */
  public function getCategories( $catLevel = 1, $resultIndex = false ) {
    $results = ( $resultIndex === false ? $this->queryCache[ $this->queryKeys[ (count( $this->queryCache ) - 1) ] ] : $this->queryCache[ $this->queryKeys[ $resultIndex ] ] );

    $categories = array();
    if( !empty($results['categorylist']) && is_array($results['categorylist']) ) {
      $categories = array( "cat{$catLevel}" => array() );

      foreach( $results['categorylist'] as $cat ) {
        if( $cat["cat{$catLevel}num"] !== 0 && !isset( $categories["cat{$catLevel}"][ $cat["cat{$catLevel}num"] ] ) ) {
          $categories["cat{$catLevel}"][ $cat["cat{$catLevel}num"] ] = $cat["category{$catLevel}"];
        }
      }
    }

    return $categories;
  }
}
?>