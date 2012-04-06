/*
 * jQuery chainCSS (CSS class chaining mechanism)
 * Examples and documentation at: http://overfoc.us/chainCSS/
 * Copyright (c) 2012 J. Newman
 * Version: 1.0 (20-JAN-2012)
 * Dual licensed under the MIT and GPL licenses.
 * http://overfoc.us/foldout/license.html
 * Requires: jQuery v1.7.0 or later
 */
  
$.fn.chainCSS = function( method, options ) {
  var settings = $.extend( { }, {
    'defaultEvent': 'mouseenter',
    'dataSet': 'chainCSS',
    'classModes': [
      { 'className': 'chain0', 'duration': 300 },
      { 'className': 'chain1', 'duration': 300 },
      { 'className': 'chain2', 'duration': 300 },
      { 'className': 'chain3' }
    ],
    'timeouts': [ ],
    'mode': 0,
    'preventDefault': false
  }, (typeof( method ) === 'object' ? method : options));

  if( settings.defaultEventInverted === undefined ) {
    switch( settings.defaultEvent ) {
      case 'mouseenter':
      default:
        settings.defaultEventInverted = 'mouseleave';
        break;
    }
  }
  
  var cancelEvents = function( $this, direction, data ) {
    var pos = undefined;

    if( direction == undefined ) {
      // undefined direction, set to default of 'open' / normal
      direction = 'open';
    }
    
    if( direction === 'open' ) {
      for( pos = 0; pos < data.timeouts.length; pos++ ) {
        if( data.timeouts[ pos ] !== undefined ) {
          clearTimeout( data.timeouts[ pos ] );
          data.timeouts[ pos ] = undefined;
        }
      }
    } else if( direction === 'close' ) { // direction is reverse (or a closing operation)
      for( pos = data.timeouts.length; pos >= 0; pos-- ) {
        if( data.timeouts[ pos ] !== undefined ) {
          clearTimeout( data.timeouts[ pos ] );
          data.timeouts[ pos ] = undefined;
        }
      }
    }
    
    // cache the new data object sans events
    $this.data( data.dataSet, data );
  }
  
  var seqForward = function( $this, e ) {
    if( !$this.hasClass('chainCSS-enabled') ) {
      $this = $this.parents( '.chainCSS-enabled' );
    }
    var customSequence = false;

    var seqSettings = undefined;
    if( e === undefined || (typeof(e) === 'object' && e.originalEvent !== undefined) ) {
      // use the internal sequence
      customSequence = false;
      seqSettings = $this.data( settings.dataSet );
    } else {
      customSequence = true; // custom supplied sequence
      seqSettings = e;
    }

    // make sure we aren't ignoring events
    if( !customSequence &&  seqSettings.preventDefault === true ) {
      return $this;
    }

    cancelEvents( $this, 'open', seqSettings );
    var timeOffset = 0;
    var mode = seqSettings.mode;
    var modes = seqSettings.classModes;
    var noCache = false;
    var dataSet = undefined;
    if( mode < 0 ) {
      mode = 0;
    }
    
    // set timeouts for future chains starting from the current mode (level)
    for( ; mode < modes.length; mode++ ) {
      if( !mode ) {
        $this.addClass( modes[ 0 ].className );
      }
    
      timeOffset += modes[ mode ].duration;
      if( modes[ (mode + 1) ] !== undefined ) {
        seqSettings.timeouts[ mode ] = setTimeout( '$("#' + $this.attr('id') +'").addClass("' + modes[ (mode + 1) ].className + '")', timeOffset );
      }
    }
    mode--;

    seqSettings.mode = mode;
    if( !noCache && seqSettings.dataSet ) {
      $this.data( seqSettings.dataSet, seqSettings );
    }
    return $this;
  }

  var seqReverse = function( $this, e ) {
    if( !$this.hasClass('chainCSS-enabled') ) {
      $this = $this.parents( '.chainCSS-enabled' );
    }
    var customSequence = false;

    var seqSettings = undefined;
    if( e === undefined || (typeof(e) === 'object' && e.originalEvent !== undefined) ) {
      // use the internal sequence
      customSequence = false;
      seqSettings = $this.data( settings.dataSet );
    } else {
      customSequence = true; // custom supplied sequence
      seqSettings = e;
      var tempData = $this.data( seqSettings.dataSet );
      if( typeof( tempData ) === 'object' ) {
        seqSettings = tempData;
      }
    }

    // make sure we aren't ignoring events
    if( !customSequence &&  seqSettings.preventDefault === true ) {
      return $this;
    }

    cancelEvents( $this, 'close', seqSettings );
    var timeOffset = 0;
    var mode = seqSettings.mode;
    var modes = seqSettings.classModes;
    var noCache = false;
    var dataSet = undefined;
    if( mode < 0 ) {
      mode = 0;
    }
    
    // set timeouts for future chains starting from the current mode (level)
    for( ; mode >= 0; mode-- ) {
      if( modes[ mode ].duration !== undefined ) {
        timeOffset += modes[ mode ].duration;
      }

      seqSettings.timeouts[ mode ] = setTimeout( '$("#' + $this.attr('id') +'").removeClass("' + modes[ mode ].className + '")', timeOffset );
    }

    seqSettings.mode = mode;
    if( !noCache && seqSettings.dataSet ) {
      $this.data( seqSettings.dataSet, seqSettings );
    }
    return $this;
  }
  
  var methods = {
    'seqForward': function( $this, options ) {
      if( options !== undefined ) {
        var combined = $.extend( { }, settings, options );
      }
      seqForward( $this, combined );
    },
    'seqReverse': function( $this, options ) {
      if( options !== undefined ) {
        var combined = $.extend( { }, settings, options );
      }
      seqReverse( $this, combined );
    }
  };
  
  if( typeof( method ) === 'string' ) {
    if( methods[ method ] !== undefined ) {
      methods[ method ]( this, options );
    }
    return this;
  }

  return this.each(function() {
    var $container = $(this);
    $container.addClass('chainCSS-enabled');
    $container.data(settings.dataSet, settings);
    
    if( settings.noBind === undefined ) { // if noBind is specified we don't bind any events
      $container.bind( settings.defaultEvent, function( e ) {
        if( settings.preventDefault === false ) {
          var $this = $(e.target);
          seqForward( $this, e );
        }
      });
      $container.bind( settings.defaultEventInverted, function( e ) {
        if( settings.preventDefault === false ) {
          var $this = $(e.target);
          seqReverse( $this, e );
        }
      });
    }
  });
};