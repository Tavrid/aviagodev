ko = require "knockout"
ko.bindingHandlers.autocomplete = init: (element, valueAccessor, allBindingsAccessor, data, context) ->
  el = data[valueAccessor()]
  $(element).autocomplete
    source: (req, res)->
      $.ajax
        url: Routing.generate "bundles_default_search_city"
        dataType: "json"
        data:
          q:req.term
        success: (data) ->
          arr = []
          $.each data,(key, val) ->
            arr.push
              value: val.name
              'data-value': val.id
            return undefined
          res arr.splice 0,10
          return undefined
    minLength: 3
    select: ( event, ui ) ->
      el ui.item['data-value']
      return undefined

