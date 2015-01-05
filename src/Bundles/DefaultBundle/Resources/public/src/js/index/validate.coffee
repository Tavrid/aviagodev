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
        params =
          adults: parseInt data.adults()
          children: if data.children() then parseInt data.children() else 0
          infant: if data.infant() then parseInt data.infant() else 0
          "class" : data.aviaClass()
          return_way: parseInt data.direction()
          currency: data.currency()
          avia_company: data.aviaCompany()
          best_price: if data.bestPrice() then 1 else 0
          direct_flights: if data.directFlights() then 1 else 0
        if data.complexSearch()
          cityCodes = []
          date = []
          _.each data.complexFields(), (o) ->
            cityCodes.push "#{o.cityFromCode()}-#{o.cityToCode()}"
            date.push o.date()
          params.city = cityCodes.join "_"
          params.date = date.join "_"
          url = Routing.generate "bundles_default_search_complex_search",params
        else
          params.city_from_code = data.cityFromCode()
          params.city_to_code = data.cityToCode()
          params.date_from = data.dateFrom()
          params.date_to = data.dateTo()
          url =  Routing.generate "bundles_default_api_list",params
        window.location = url
        false

      ignore: ":hidden"



  )

