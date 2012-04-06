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