<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Pricetime.com</title>

    <!-- local resources -->
    <link rel="stylesheet" href="/css/reset.css" type="text/css">
    <link rel="stylesheet/less" type="text/css" href="/css/style.less">
    <link rel="shortcut icon" href="/favicon.ico">

    <!-- libraries / etc -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery-1.7.2.min.js">\x3C/script>')</script>
    <script src="/js/less-1.3.0.min.js" type="text/javascript"></script>

    <!-- google fonts and html5shiv (html5 support for older browsers) -->
    <link href='http://fonts.googleapis.com/css?family=Cantarell:700italic,700|Droid+Sans:400,700' rel='stylesheet' type='text/css'>
    <? if( $page == 'search' ) { ?><script> var __REQUEST_URI = '/search?<?=paramFilter(array('sort'))?>'; </script><? } ?>
    
    <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body class="<?=$page?>">
    <a href="https://github.com/DataFeedFile-com/PriceTime.com"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://a248.e.akamai.net/assets.github.com/img/e6bef7a091f5f3138b8cd40bc3e114258dd68ddf/687474703a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub"></a>
    <div class="wrapper">


      <div class="logo-box">
        <a href="/"><img src="/images/icon.png" id="logo" />
          <span class="price">Price</span><span class="time">Time</span><span class="dot-com">.com</span>
        </a>
        <form action="/search" method="get">
          <div class="input-container">
            <input type="text" name="keyword" id="search" placeholder="" class="focus" value="<?=(isset( $_GET['keyword'] ) ? $_GET['keyword'] : '')?>" />
            <button class="big button"><span>Find it!</span></button>
          </div>
        </form>
      </div>
      <div class="debug"><?=(!empty($query) ? $query : '')?></div>
      <? if( $page != 'home' ) { ?>
        <div class="center-ad">
          <script type="text/javascript"><!--
            google_ad_client = "ca-pub-9302935271891976";
            /* pricetime_top_leaderboard_image */
            google_ad_slot = "2117985343";
            google_ad_width = 728;
            google_ad_height = 90;
            //-->
          </script>
          <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
        </div>
      <? } ?>