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
        cityCodes = []
        date = []
        _.each data.complexFields(), (o) ->
          cityCodes.push "#{o.cityFromCode()}-#{o.cityToCode()}"
          date.push o.date()

        console.log Routing.generate "bundles_default_search_complex_search",
          city: cityCodes.join "_"
          date: date.join "_"
          adults: data.adults()
          children: data.children()
          infant: data.infant()
          "class" : data.aviaClass()
          return_way: data.direction()
          currency: data.currency()
          avia_company: data.aviaCompany()
          best_price: 0+!!data.bestPrice()
          direct_flights: 0+!!data.directFlights()
        console.log Routing.generate "bundles_default_api_list",
          city_from_code: data.cityFromCode()
          city_to_code: data.cityToCode()
          date_from: data.dateFrom()
          date_to: data.dateTo()
          adults: data.adults()
          children: data.children()
          infant: data.infant()
          "class" : data.aviaClass()
          return_way: data.direction()
          currency: data.currency()
          avia_company: data.aviaCompany()
          best_price: 0+!!data.bestPrice()
          direct_flights: 0+!!data.directFlights()
        false

      ignore: ":hidden"



  )

