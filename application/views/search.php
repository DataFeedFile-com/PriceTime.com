      <div class="container">

        <div class="results-bar clearfix block">
          <div class="result-count">Showing <em><?=number_format($_GET['offset'] + 1)?> through <?=number_format($_GET['offset'] + $_GET['limit'])?></em> of <?=number_format($results['product_count'])?> results</div>

          <div class="top-control">
            <div class="label">Sort by: </div>
            <select name="sort">
              <option value="relevance" <?=( (isset($_GET['sort']) && $_GET['sort'] == 'relevance') || !isset($_GET['sort']) ? 'selected' : '' )?>>Relevance</option>
              <option value="priceasc" <?=( (isset($_GET['sort']) && $_GET['sort'] == 'priceasc') ? 'selected' : '' )?>>Price (low to high)</option>
              <option value="pricedesc" <?=( (isset($_GET['sort']) && $_GET['sort'] == 'pricedesc') ? 'selected' : '' )?>>Price (high to low)</option>
              <option value="prdtrating" <?=( (isset($_GET['sort']) && $_GET['sort'] == 'prdtrating') ? 'selected' : '' )?>>Product Rating</option>
              <option value="storerating" <?=( (isset($_GET['sort']) && $_GET['sort'] == 'storerating') ? 'selected' : '' )?>>Store Rating</option>
            </select>
          </div>
          <div class="clear">
            Results per page: <select id="limit" name="limit">
              <option <?=($_GET['limit'] == 10 ? 'selected' : '')?>>10</option>
              <option <?=($_GET['limit'] == 20 ? 'selected' : '')?>>20</option>
            </select>

            <!-- top pagination -->
            <div class="pagination">
              <?
              if($pagination['start'] > 1) {
                ?><a href="<?=( '/search?' . $pagination['qString'] . '&page=1' )?>">1</a> <?=($pagination['start'] > 2 ? '...' : '')?><?
              }

              for($x = $pagination['start']; $x <= $pagination['end']; $x++) {
                ?><a href="<?=( '/search?' . $pagination['qString'] . '&page=' . $x )?>" data-page="<?=$x?>" class="<?=($x == $_GET['page'] ? 'active' : '')?>"><?=$x?></a><?
              }

              if($pagination['end'] < $pagination['total']) {
                ?> <?=(($pagination['total'] - $pagination['end']) > 1 ? '...' : '')?><a href="<?=( '/search?' . $pagination['qString'] . '&page=' . $pagination['total'] )?>" data-page="<?=$pagination['total']?>"><?=$pagination['total']?></a><?
              }
              ?>
            </div>
          </div>
        </div>

        <? if( !empty( $results ) ) { $count = 0; ?>
          <? foreach( $results['productlist'] as $result ) { ?>
            <?
            if( $result['corenum'] == 0 ) {
              $core = false;
              $product_url = "http://www.datafeedfile.com/dff_prdtclick.php?affid={$aff_id}&prdtid={$result['prdtid']}";
            } else {
              $core = true;
              $product_url = "/product/compare/{$result['corenum']}";
            }
            ?>
            <? if( $count++ == intval( intval($_GET['limit']) / 2) ) { ?>
              <div class="ad">
                <script type="text/javascript"><!--
                  google_ad_client = "ca-pub-9302935271891976";
                  /* pricetime_middle_leaderboard_text */
                  google_ad_slot = "3820339932";
                  google_ad_width = 728;
                  google_ad_height = 90;
                  //-->
                </script>
                <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
              </div>
            <? } else { ?>
              <div class="product clearfix block">
                <img class="main" src="<?=$result['imgurl']?>" />
                <? if( !empty( $result['shortdesc'] ) ) { ?><div class="short-desc"> <?=$result['shortdesc']?> </div> <? } ?>
                <div class="mer-info">
                  <? if( !empty( $result['mernum'] ) ) { ?><img class="mer-logo" src="http://cimages.datafeedfile.com/images/merimages/<?=$result['mernum']?>/<?=$result['mernum']?>_image1.gif" /> <? } ?>
                  <? if( !empty( $result['mernum'] ) ) { ?><div class="merchant"><span><?=$result['mername']?></span></div> <? } ?>
                </div>
                <? if( !empty( $result['longdesc'] ) ) { ?>
                  <div class="description">
                    <div class="content"><?=$result['longdesc']?></div>
                  </div>
                  <button class="expand button"><span>See full description...</span></button>
                <? } ?>
                <div class="price"> $<?=number_format( $result['prdtprice'], 2 )?> </div>
                <? $result['sellercount'] = ( isset( $result['sellercount'] ) ? $result['sellercount'] : 0 ); ?>
                <a href="<?=$product_url?>" class="more-info-button"> <span><?=($core ? "Compare from {$result['sellercount']} stores" : 'More Info')?></span> </a>
              </div>
            <? } ?>
          <? } ?>
        <? } ?>

        <!-- bottom pagination -->
        <div class="results-bar clearfix block">
          <div class="pagination">
            <?
            if($pagination['start'] > 1) {
              ?><a href="<?=( '/search?' . $pagination['qString'] . '&page=1' )?>">1</a> <?=($pagination['start'] > 2 ? '...' : '')?><?
            }

            for($x = $pagination['start']; $x <= $pagination['end']; $x++) {
              ?><a href="<?=( '/search?' . $pagination['qString'] . '&page=' . $x )?>" data-page="<?=$x?>" class="<?=($x == $_GET['page'] ? 'active' : '')?>"><?=$x?></a><?
            }

            if($pagination['end'] < $pagination['total']) {
              ?> <?=(($pagination['total'] - $pagination['end']) > 1 ? '...' : '')?><a href="<?=( '/search?' . $pagination['qString'] . '&page=' . $pagination['total'] )?>" data-page="<?=$pagination['total']?>"><?=$pagination['total']?></a><?
            }
            ?>
          </div>
        </div>
      </div>