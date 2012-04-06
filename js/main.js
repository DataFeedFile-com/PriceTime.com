$(function() {
  $('.focus').focus();

  $('select[name=sort]').change(function( e ) {
    window.location = window.__REQUEST_URI + '&sort=' + $(this).val();
  });

  $('#limit').change( function( e ) {
    window.location = window.__REQUEST_URI + '&limit=' + $(this).val();
  });

  // check for the height of the descriptions, and enable the expand button if needed
  var $descriptions = $('.product .description > .content');
  $descriptions.each( function( index, el ) {
    var $this = $(this);
    var $content = $(el), contentHeight = $content.height();
    if( contentHeight > '40' ) {
      // we must show the button to expand the description
      $this.parents('.product').children('.button').addClass('visible');
    }
  });

  $('.product .expand.button').click( function( e ) {
    var $this = $(this);
    $this.siblings('.description').addClass('full-view');
    $this.removeClass('visible');
    
    e.preventDefault();
  });
});