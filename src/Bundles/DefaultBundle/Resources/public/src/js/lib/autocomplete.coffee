ko = require "knockout"
typehead = require "typeahead"
Delay = require "./delay"
delObj = new Delay()

ko.bindingHandlers.autocomplete = init: (element, valueAccessor, allBindingsAccessor, data, context) ->
  el = data[valueAccessor()]
  $(element).attr 'autocomplete', 'off'
  t = typehead element,
    source: (req, res)->
      self = this
      delObj.setTimeout ->
        $.ajax
          url: Routing.generate "bundles_default_search_city"
          dataType: "json"
          data:
            q:req
          success: (data) ->
            arr = []
            d = []
            $.each data,(key, val) ->
              arr.push val.name
              d.push val
              return undefined

            res arr.splice 0,10
            self.data = d.splice 0,10

      ,300
    minLength: 3
    matcher: (item) ->
      return true


  t.show =  ->
    self = this
    offset = self.element.offset()
    self.menu.css({left: "#{offset.left}px",top: "#{offset.top + self.element.outerHeight()}px"})
    self.menu.removeClass "hidden"
    self.shown = true
    self
  t.select = ->
    self = this
    val = self.menu.find('.active').attr('data-value')
    self.element.value(self.updater(val)).emit('change')

    index = $(self.menu.find('.active')).index()
    el(self.data[index].id)
    return undefined
  return undefined
#  typehead.prototype.select = ->
#    console.log this

