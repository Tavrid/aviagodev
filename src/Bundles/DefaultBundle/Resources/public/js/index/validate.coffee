ko = require "knockout"
typehead = require "typeahead"
Delay = require "./delay"
delObj = new Delay()
_ = require "underscore"

ko.bindingHandlers.validate = init: (element, valueAccessor, allBindingsAccessor, data, context) ->

  $(->
    $(element).validate
      highlight: (element) ->
        $(element).closest(".form-group").addClass "has-error"
        return

      unhighlight: (element) ->
        $(element).closest(".form-group").removeClass "has-error"
        return

      errorElement: "span"
      errorClass: "help-block"
      errorPlacement: (error, element) ->
        if element.parent(".input-group").length
          error.insertAfter element.parent()
        else
          error.insertAfter element
        return

      submitHandler: (form) ->
        str = []
        _.each data.complexFields(), (o) ->
          str.push "#{o.cityFromCode()}_#{o.cityToCode()}_#{o.date()}"
        console.log str.join "."
        false

      ignore: ":hidden"



  )

