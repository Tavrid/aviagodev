ko = require "knockout"
typehead = require "typeahead"
Delay = require "./delay"
delObj = new Delay()
_ = require "underscore"

ko.bindingHandlers.datepicker = init: (element, valueAccessor, allBindingsAccessor, data, context) ->

  $(->
    $(element).attr 'autocomplete', 'off'
    $(element).datepicker
      numberOfMonths: 3
      dateFormat: "yy-mm-dd"
      beforeShow: (el,cont) ->
        prev = {}
        _.each context.$root.complexFields(),(o,i) ->
          if o == data
            prev = context.$root.complexFields()[(i-1)] || {}  if i > 0
        if prev.date?
          $(this).datepicker "option", "minDate", prev.date() || new Date()
        else
          $(this).datepicker "option", "minDate", new Date()



  )

