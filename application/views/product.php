<div class="container">
  <a href="javascript:window.history.go(-1)" class="back">... back to search results.</a>
  <div class="main product clearfix block">
    <img src="<?=$product_details['product_info']['thumbnail']['url']?>" />
    <div class="details">
      <div class="name"> <?=$product_details['product_info']['prdtname']?> </div>
      <div class="description"> <?=$product_details['product_info']['longdesc']?> </div>
      <div class="mfg"> <?=$product_details['product_info']['mfgname']?> </div>
    </div>
  </div>
</div>

<? if( count( $product_details['price_comparison'] ) ) { ?>
  <div class="title">...compare from <em><b><?=count($product_details['price_comparison'])?></b> different stores</em>:</div>
  <div id="product-compare">
    <? foreach( $product_details['price_comparison'] as $product ) { ?>
      <div class="product clearfix block" href="<?=$product['prdtclickurl']?>">
        <table cellpadding="0" cellspacing="0">
          <tr><td align="center" valign="center"><img src="<?=$product['imgurl']?>" /></td></tr>
        </table>
        
        <div class="content">
          <? if( !empty( $product['mername'] ) ) { ?><div class="merchant">Store: <span><?=$product['mername']?></span></div> <? } ?>
          <div class="price"> $<?=number_format( $product['merprice'], 2 )?> </div>
          <img class="mer-logo" src="<?=$product['merlogourl']?>" />
          <a href="<?=$product['prdtclickurl']?>" class="button more-info-button"><span>More Info</span></a>
        </div>
      </div>
    <? } ?>
  </div>
<? } ?>