<div id="left-menu">

  <div class="selected-items">

    <!-- Selected categories -->
    <? $cats = false; for( $x = 1; $x <= 3; $x++ ) {
      if( isset( $_GET["cat{$x}num"] ) ) {
        $cats = true;
      }
    } ?>
    <? if( $cats ) { ?>
      <div class="section">
        <div class="title">Categories</div>
        <? for( $x = 1; $x <= 3; $x++ ) { ?>
          <? if( isset( $_GET["cat{$x}num"] ) ) { ?>
            <a title="click to remove" class="selected-category" href="/search?<?=paramFilter( array( "cat{$x}num", "cat{$x}name", "page", "limit", "offset" ), false )?>"><span><?=$_GET["cat{$x}name"]?></span></a>
          <? } ?>
        <? } ?>
      </div>
    <? } ?>

    <!-- Selected manufacturers -->
    <? if( isset( $_GET["mfgnum"] ) ) { ?>
      <div class="section">
        <div class="title">Manufacturers</div>
        <a title="click to remove" class="selected-category" href="/search?<?=paramFilter( array( "mfgnum", "mfgname", "page", "limit", "offset" ), false )?>"><span><?=$_GET["mfgname"]?></span></a>
      </div>
    <? } ?>

    <!-- Selected price range -->
    <? if( isset( $_GET["pricelow"] ) ) { ?>
      <div class="section">
        <div class="title">Price Range</div>
        <a title="click to remove" class="selected-category" href="/search?<?=paramFilter( array( "pricelow", "pricehigh", "pricename", "page", "limit", "offset" ), false )?>"><span><?=$_GET["pricename"]?></span></a>
      </div>
    <? } ?>

  </div>
  <script> if( $('.selected-items .section').children().length === 0 ) { $('.selected-items').css('display', 'none'); } </script>

  <!-- Display unselected category options -->
  <? if( !empty($categories) ) { ?>
    <div id="categories-list">
      <? foreach( $categories as $catLevel => $categories ) { ?>
        <div class="category" id="<?=$catLevel?>">
          <div class="title"> Category <?=preg_replace("/[^0-9,.]/", "", $catLevel)?> </div>
          <div class="categories clearfix">
            <? foreach( $categories as $catNum => $category ) { ?>
              <a href="/search?<?=$catLevel?>num=<?=$catNum?>&<?=$catLevel?>name=<?=urlencode($category)?><?=paramFilter( array( "{$catLevel}num", "{$catLevel}name", "page", "limit", "offset" ) )?>" class="category cat<?=$catNum?>" data-num="<?=$catNum?>"><?=$category?></a>
            <? } ?>
          </div>
        </div>
      <? } ?>
    </div>
  <? } ?>

  <!-- Display manufacturers options -->
  <? if( !empty($results['manufacturerlist']) ) { ?>
    <div id="mfg-list" class="facets">
      <div class="title">Manufacturers</div>
      <div class="mfgs facet-list">
        <? foreach( $results['manufacturerlist'] as $mfg ) { ?>
          <a href="/search?mfgnum=<?=$mfg['mfgnum']?>&mfgname=<?=urlencode($mfg['mfgname'])?><?=paramFilter( array( "page", "limit", "offset" ) )?>" class="mfg facet" title="<?=$mfg['mfgname']?>"><div class="container facet"><?=str_replace(' ', '&nbsp;', $mfg['mfgname'])?></div> <span>(<?=$mfg['count']?>)</span></a>
        <? } ?>
      </div>
    </div>
  <? } ?>

  <!-- Display merchant options -->
  <? if( !empty($results['merchantlist']) ) { ?>
    <div id="mer-list" class="facets">
      <div class="title">Merchants</div>
      <div class="mers facet-list">
        <? foreach( $results['merchantlist'] as $mer ) { ?>
          <a href="/search?mernum=<?=$mer['mernum']?>&mername=<?=urlencode($mer['mername'])?><?=paramFilter( array( "page", "limit", "offset" ) )?>" class="facet" title="<?=$mer['mername']?>"><div class="container facet"><?=str_replace(' ', '&nbsp;', $mer['mername'])?></div> <span>(<?=$mer['count']?>)</span></a>
        <? } ?>
      </div>
    </div>
  <? } ?>


  <!-- Price Ranges -->
  <? if( !empty($results['pricelist']) && !isset( $_GET['pricelow'] ) ) { ?>
    <div id="price-list" class="facets">
      <div class="title">Price Range</div>
      <div class="facet-list">
        <? foreach( $results['pricelist'] as $price ) { ?>
          <?
          $range = explode('_', $price['name']);
          $low = ''; $high = '';
          if( $range[0] == 'under' ) {
            $humanRange = 'under $'.number_format((int)$range[1]);
            $low = ''; $high = $range[1];
          } else if( $range[0] == 'over' ) {
            $humanRange = 'over $'.number_format((int)$range[1]);
            $low = $range[1]; $high = '';
          } else {
            $humanRange = '$'.number_format((int)$range[0]).' to $'.number_format((int)$range[1]);
            $low = $range[0]; $high = $range[1];
          }
          ?>
          <a href="/search?pricelow=<?=$low?>&pricehigh=<?=$high?>&pricename=<?=urlencode($humanRange)?><?=paramFilter( array('pricelow', 'pricehigh', 'pricename', 'page', 'limit', 'offset') )?>" class="price facet" title="<?=$humanRange?>"><div class="container facet"><?=str_replace(' ', '&nbsp;', $humanRange)?></div> <span>(<?=number_format($price['count'])?>)</span></a>
        <? } ?>
      </div>
    </div>
  <? } ?>
</div>