ko = require "knockout"
ko.bindingHandlers.autocomplete = init: (element, valueAccessor, allBindingsAccessor, data, context) ->
  el = data[valueAccessor()]
  $(element).autocomplete
    source: (req, res)->
      res [123445,2,3,4,5]