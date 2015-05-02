ko = require "knockout"
typehead = require "typeahead"
_ = require "underscore"
Delay = require "./delay"
delObj = new Delay()

ko.bindingHandlers.autocomplete = init: (element, valueAccessor, allBindingsAccessor, data, context) ->
  el = data[valueAccessor()]
  $(element).attr 'autocomplete', 'off'
#  codeContainer = $(element).siblings ".auto-code"
#  $(element).on 'keyup', ->
#    codeContainer.html ''
  t = typehead element,
    source: (req, res)->
      self = this
#      codeContainer.html ''
#        .hide()
      el null
      delObj.setTimeout ->
        $.ajax
          url: Routing.generate "bundles_default_search_city"
          dataType: "json"
          data:
            q:req
          success: (data) ->
            res data.splice 0,10

      ,300
    minLength: 3
    matcher: (item) ->
      return true


  t.show =  ->
    self = this
    offset = self.element.offset()
    self.menu.css({left: "#{offset.left}px",top: "#{offset.top + self.element.outerHeight()}px", width: "#{self.element.outerWidth()}px"})
    self.menu.removeClass "hidden"
    self.shown = true
    self
  t.select = ->
    self = this
    val = self.menu.find('.active').attr('data-value')
    id = self.menu.find('.active').attr('data-id')
    self.element.value(self.updater(val)).emit('change')
#    codeContainer.html id
#      .show()
    el(id)
    return undefined
  t.sorter = (items) ->
    return items
  t.render = (items) ->
    self = this
    self.menu.empty()
    _.each items, (num)->
      if !num.child && ((num.code.search new RegExp self.query, 'ig') != -1 || (num.airport.search new RegExp self.query, 'ig') != -1)
        self.menu.append "<li data-id='#{num.code}' data-value='#{num.airport}, #{num.name}' ><a href=\"\">#{self.highlighter num.name}, #{self.highlighter num.airport}<strong class='pull-right'>#{self.highlighter num.code}</strong><br /><small style='text text-muted'>#{num.country}</small></a></li>"
      else
        self.menu.append "<li data-id='#{num.id}' data-value='#{num.name}, #{num.country}' ><a href=\"\">#{self.highlighter num.name}<strong class='pull-right'>#{self.highlighter num.id}</strong><br /><small style='text text-muted'>#{num.country}</small></a></li>"
      if num.child
        _.each num.child, (ch)->
          self.menu.append "<li data-id='#{ch.code}' data-value='#{ch.airport}, #{ch.name}' class='child'><a style='padding-left: 20px' href=\"\">#{self.highlighter ch.airport}<strong class='pull-right'>#{ch.code}</strong></a></li>"

    return self


  return undefined
#  typehead.prototype.select = ->
#    console.log this

