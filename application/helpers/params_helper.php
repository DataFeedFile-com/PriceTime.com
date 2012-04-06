<?

function array_implode_url( $array, $glue = '=', $separator = '&' ) {
  if ( ! is_array( $array ) ) {
    return $array;
  }

  $string = array();
  foreach ( $array as $key => $val ) {
    if( is_array( $val ) ) {
      $val = implode( ',', $val );
    }
    $val = urlencode($val);

    $string[] = "{$key}{$glue}{$val}";
  }

  return implode( $separator, $string );
}

function paramFilter( $params = array(), $prepend = true ) {
  $params = array_implode_url( array_diff_key( $_GET, array_flip( $params ) ) );
  return ( (strlen( $params ) && $prepend ? '&' : '') . $params );
}

?>