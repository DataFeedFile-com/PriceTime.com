/*
 * jQuery inputContainer (usability plugin to enhance input elements)
 * Examples and documentation at: http://overfoc.us/inputContainer/
 * Copyright (c) 2011 J. Newman
 * Version: 1.0 (08-DEC-2011)
 * Dual licensed under the MIT and GPL licenses.
 * http://overfoc.us/inputContainer/license.html
 * Requires: jQuery v1.7.0 or later
 */
$.fn.inputContainer = function() {
  return this.each(function() {
    var $container = $(this);
    $container.bind( 'click' , function(e) {
      var $this = $(e.target),
          $element = undefined,
          checked = false;
      
      if( $this.is('label, input, select') ) {
        e.stopPropagation();
      }
      
      // find the input element for the container
      switch( $this.get(0).tagName ) {
        case 'label': // user clicked the label
          $element = $this.siblings('input');
          break;
        case 'input': // user clicked an input element
          $element = $this;
          break;
        default: // user clicked the container element
          $element = $this.children('input');
          break;
      }
      
      // if this is a radio element we must 'deselect' other radios with this name by removing the .active class from the container
      if( $element.is('input[type=radio]') ) {
        $('input[type=radio][name=' + $element.attr('name') + ']').parent().removeClass('active');
      }
      
      // set/focus the input element, and add the .active class to the container if it is proper to do so
      if( $element.is('input[type=checkbox], input[type=radio]') ) {
        checked = ( !$element.prop('checked') || $element.is('input[type=radio]') );
        if( checked ) {
          $element.parent().addClass('active');
        } else {
          $element.parent().removeClass('active');
        }
        $element.prop('checked', checked );
      } else {
        $element.focus();
      }
    });
  });
};