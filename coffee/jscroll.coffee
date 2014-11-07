#!
# * jScroll - jQuery Plugin for Infinite Scrolling / Auto-Paging - v2.2.4
# * http://jscroll.com/
# *
# * Copyright 2011-2013, Philip Klauzinski
# * http://klauzinski.com/
# * Dual licensed under the MIT and GPL Version 2 licenses.
# * http://jscroll.com/#license
# * http://www.opensource.org/licenses/mit-license.php
# * http://www.gnu.org/licenses/gpl-2.0.html
# *
# * @author Philip Klauzinski
# * @requires jQuery v1.4.3+
# 
(($) ->
  
  # Define the jscroll namespace and default settings
  $.jscroll = defaults:
    debug: false
    autoTrigger: true
    autoTriggerUntil: false
    loadingHtml: "<small>Loading...</small>"
    padding: 0
    nextSelector: "a:last"
    contentSelector: ""
    pagingSelector: ""
    callback: false

  
  # Constructor
  jScroll = ($e, options) ->
    
    # Private vars
    
    # Initialization
    
    # Private methods
    
    # Check if a loading image is defined and preload
    _preloadImage = ->
      src = $(_options.loadingHtml).filter("img").attr("src")
      if src
        image = new Image()
        image.src = src
      return
    
    # Wrapper inner content, if it isn't already
    _wrapInnerContent = ->
      $e.contents().wrapAll "<div class=\"jscroll-inner\" />"  unless $e.find(".jscroll-inner").length
      return
    
    # Find the next link's parent, or add one, and hide it
    _nextWrap = ($next) ->
      if _options.pagingSelector
        $parent = $next.closest(_options.pagingSelector).hide()
      else
        $parent = $next.parent().not(".jscroll-inner,.jscroll-added").addClass("jscroll-next-parent").hide()
        $next.wrap("<div class=\"jscroll-next-parent\" />").parent().hide()  unless $parent.length
      return
    
    # Remove the jscroll behavior and data from an element
    _destroy = ->
      _$scroll.unbind(".jscroll").removeData("jscroll").find(".jscroll-inner").children().unwrap().filter(".jscroll-added").children().unwrap()
    
    # Observe the scroll event for when to trigger the next load
    _observe = ->
      _wrapInnerContent()
      $inner = $e.find("div.jscroll-inner").first()
      data = $e.data("jscroll")
      borderTopWidth = parseInt($e.css("borderTopWidth"))
      borderTopWidthInt = (if isNaN(borderTopWidth) then 0 else borderTopWidth)
      iContainerTop = parseInt($e.css("paddingTop")) + borderTopWidthInt
      iTopHeight = (if _isWindow then _$scroll.scrollTop() else $e.offset().top)
      innerTop = (if $inner.length then $inner.offset().top else 0)
      iTotalHeight = Math.ceil(iTopHeight - innerTop + _$scroll.height() + iContainerTop)
      if not data.waiting and iTotalHeight + _options.padding >= $inner.outerHeight()
        
        #data.nextHref = $.trim(data.nextHref + ' ' + _options.contentSelector);
        _debug "info", "jScroll:", $inner.outerHeight() - iTotalHeight, "from bottom. Loading next request..."
        _load()
    
    # Check if the href for the next set of content has been set
    _checkNextHref = (data) ->
      data = data or $e.data("jscroll")
      if not data or not data.nextHref
        _debug "warn", "jScroll: nextSelector not found - destroying"
        _destroy()
        false
      else
        _setBindings()
        true
    _setBindings = ->
      $next = $e.find(_options.nextSelector).first()
      if _options.autoTrigger and (_options.autoTriggerUntil is false or _options.autoTriggerUntil > 0)
        _nextWrap $next
        _observe()  if _$body.height() <= _$window.height()
        _$scroll.unbind(".jscroll").bind "scroll.jscroll", ->
          _observe()

        _options.autoTriggerUntil--  if _options.autoTriggerUntil > 0
      else
        _$scroll.unbind ".jscroll"
        $next.bind "click.jscroll", ->
          _nextWrap $next
          _load()
          false

      return
    
    # Load the next set of content, if available
    _load = ->
      $inner = $e.find("div.jscroll-inner").first()
      data = $e.data("jscroll")
      data.waiting = true
      $inner.append("<div class=\"jscroll-added\" />").children(".jscroll-added").last().html "<div class=\"jscroll-loading\">" + _options.loadingHtml + "</div>"
      $e.animate
        scrollTop: $inner.outerHeight()
      , 0, ->
        $inner.find("div.jscroll-added").last().load data.nextHref, (r, status, xhr) ->
          return _destroy()  if status is "error"
          $next = $(this).find(_options.nextSelector).first()
          data.waiting = false
          data.nextHref = (if $next.attr("href") then $.trim($next.attr("href") + " " + _options.contentSelector) else false)
          $(".jscroll-next-parent", $e).remove() # Remove the previous next link now that we have a new one
          _checkNextHref()
          _options.callback.call this  if _options.callback
          _debug "dir", data
          return

        return

    
    # Safe console debug - http://klauzinski.com/javascript/safe-firebug-console-in-javascript
    _debug = (m) ->
      if _options.debug and typeof console is "object" and (typeof m is "object" or typeof console[m] is "function")
        if typeof m is "object"
          args = []
          for sMethod of m
            if typeof console[sMethod] is "function"
              args = (if (m[sMethod].length) then m[sMethod] else [m[sMethod]])
              console[sMethod].apply console, args
            else
              console.log.apply console, args
        else
          console[m].apply console, Array::slice.call(arguments_, 1)
      return
    _data = $e.data("jscroll")
    _userOptions = (if (typeof options is "function") then callback: options else options)
    _options = $.extend({}, $.jscroll.defaults, _userOptions, _data or {})
    _isWindow = ($e.css("overflow-y") is "visible")
    _$next = $e.find(_options.nextSelector).first()
    _$window = $(window)
    _$body = $("body")
    _$scroll = (if _isWindow then _$window else $e)
    _nextHref = $.trim(_$next.attr("href") + " " + _options.contentSelector)
    $e.data "jscroll", $.extend({}, _data,
      initialized: true
      waiting: false
      nextHref: _nextHref
    )
    _wrapInnerContent()
    _preloadImage()
    _setBindings()
    
    # Expose API methods via the jQuery.jscroll namespace, e.g. $('sel').jscroll.method()
    $.extend $e.jscroll,
      destroy: _destroy

    $e

  
  # Define the jscroll plugin method and loop
  $.fn.jscroll = (m) ->
    @each ->
      $this = $(this)
      data = $this.data("jscroll")
      
      # Instantiate jScroll on this element if it hasn't been already
      return  if data and data.initialized
      jscroll = new jScroll($this, m)
      return


  return
) jQuery
