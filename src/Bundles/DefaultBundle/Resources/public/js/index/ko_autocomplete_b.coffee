ko = require "knockout"
typehead = require "typeahead"
Delay = require "./delay"
delObj = new Delay()

ko.bindingHandlers.autocomplete = init: (element, valueAccessor, allBindingsAccessor, data, context) ->
  el = data[valueAccessor()]
  typehead element,
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
            $.each data,(key, val) ->
              arr.push val.name
              return undefined
            res arr.splice 0,10
            self.data = arr.splice 0,10

      ,300
    minLength: 3
    matcher: (item) ->
      return true
    change: ->

      console.log arguments
      return undefined

  typehead.select = ->
    self = this
    val = self.menu.find('.active').attr('data-value')
    self.element
    .value(self.updater(val))
    .emit('change')

