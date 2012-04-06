/*
 * jQuery easilyValid (usability plugin to perform input validation on the client side easily)
 * Examples and documentation at: http://overfoc.us/easilyValid/
 * Copyright (c) 2011 J. Newman
 * Version: 1.0 (11-DEC-2011)
 * Dual licensed under the MIT and GPL licenses.
 * http://overfoc.us/easilyValid/license.html
 * Requires: jQuery v1.7.0 or later
 */
  
$.fn.easilyValid = function( method, options ) {
  var settings = $.extend( {
    'onChange': true,
    'onKeypress': true,
    'errorPadding': -30 // extra padding/spacing between input element and error statement
  }, (typeof(method) === 'object' ? method : options));

  var setError = function($container, state) {
    var $error = undefined;

    if( !state ) {
      $container.addClass('error');
      $error = $container.children('.error');
      switch( $container.children('select, textarea, input').data('error') ) {
        case 'right':
          $error.css({ 'left': (($container.width() + parseInt($container.css('padding-left')) + parseInt($container.css('padding-right')) + settings.errorPadding) + 'px') });
          break;
        case 'left':
          $error.css({ 'left': ('-' + ($error.width() + parseInt($container.css('padding-left')) + parseInt($container.css('padding-right'))  + settings.errorPadding) + 'px') });
          break;
      }
    } else {
      $container.removeClass('error');
    }
  }
  
  var validate = function($this) {
    if( $this.originalEvent ) {
      // this is the event from an onChange, $this is the event element
      $this = $( $this.target );
    }
    var vString = '', localState = true;
    
    if( $this.data && (vString = $this.data('validate')) !== undefined ) {
      switch( vString ) {
        case '_nonblank':
          if(  $this.val() === '' ) {
            localState = false;
          }
          break;
        
        default:
          break;
      }
      setError( $this.parent(), localState );
    }
    
    return localState;
  }
  
  var methods = {
    'validate': function( $this ) {
      validate( $this );
    }
  };
  
  if( typeof( method ) === 'string' ) {
    if( methods[method] !== undefined ) {
      methods[method]( this );
    }
    return this;
  }

  if( settings.onChange ) {
    this.find('input, select, textarea').bind('change', validate);
  }
  if( settings.onKeypress ) {
    this.find('input, select, textarea').bind('keyup', validate);
  }
  
  return this.each(function() {
    var $container = $(this);
    
    $container.bind( 'submit' , function(e) {
      var $form = $(e.target),
          validated = true, currentField = undefined;
      
      // run through the form elements, and do validation if necessary
      $form.find('input, textarea, select').each(function() {
        currentField = validate( $(this) );
        validated = ( validated ? currentField : validated );
      });
      
      // return the validated state
      return validated;
    });
  });
};