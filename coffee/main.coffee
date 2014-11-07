log = (string)->
  if console
    console.log string

(($) ->

  console.log "start"
  # keypress to force reload of page
  m = $('#mast')
  $(document).bind 'keypress', (e) ->
    location.reload() if e.which is 114
  # add lightbox to Drink Special img
  #$promoImg = $(".promo img")
  #$imgsrc = $promoImg.attr("src")
  #$promoImg.wrap("<a href=\""+$imgsrc+"\" rel=\"lightbox\"></a>")


  # Calendar filtering

  calendar_button_on = 1.0
  calendar_button_hover = 0.6
  calendar_button_dim = 0.2
  mouseenter_color = "#f00"
  mouseleave_color = "#a00"

  $c = $("#page.calendar")
  $n = $c.find "nav"
  $i = $n.find "img"
  $tr = $c.find "tr"

  $i.each ->
    $(this).mouseenter ->
      $(this).css "borderColor", "#c00"
      log "mouse entered"
    $(this).mouseleave ->
      $(this).css "borderColor", mouseleave_color
    $(this).data "state", false

  dimButtons = ->
    $i.each ->
      $(this).css "opacity", calendar_button_dim


  hideAll = ->
    $tr.each ->
      if (($(this).css "opacity") > 0)
        $(this).fadeTo 500, 0, ->
          $(this).css "display", "none"

  revealAll = ->
    $tr.each ->
      if (($(this).css "opacity") < 1)
        $(this).fadeTo 500, 1

  filter_calendar = (crowd) ->
    $i.filter("." + crowd).click (e) ->
      e.preventDefault()
      dimButtons()

      if (($(this).data "state") == false)
        $tr.not("."+ crowd).not(".month").each ->
          $(this).fadeTo 500, 0, ->
            $(this).css "display", "none"
        $tr.filter("."+ crowd).each ->
          $(this).fadeTo 500, 1, ->
            $(this).css "display", "table-row"
        $i.each ->
          $(this).data "state", false
        $(this).data "state", true
        $(this).css "opacity", calendar_button_on
      else
        revealAll()
        dimButtons()
        $i.each ->
          $(this).data "state", false

  filter_calendar "music"
  filter_calendar "bears"
  filter_calendar "leather"
  # filter_calendar "drag"
  filter_calendar "special"

#
# gentle scrolling when clicking on menu item
#

  # ADDED: make sections focusable
  $("a[name]").attr "tabindex", "0"

  # end ADDED
  $("a[href*=#]:not([href=#])").click ->
    $linkElem = $(this)
    if location.pathname.replace(/^\//, "") is @pathname.replace(/^\//, "") and location.hostname is @hostname
      target = $(@hash)
      target = (if target.length then target else $("[name=" + @hash.slice(1) + "]"))
      if target.length
        $("html,body").animate { scrollTop: target.offset().top } , 1000, ->
          # ADDED: focus the target
          target.focus()
          # end ADDED
          # ADDED: update the URL
          window.location.hash = $linkElem.attr("href").substring(1)
          return

        # window.location.hash = $(this).attr('href').substring(1, $(this).attr('href').length);
        # end ADDED
        false

  return

) jQuery
