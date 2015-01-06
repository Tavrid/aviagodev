_ = require "underscore"
module.exports = class
  createSearch: (ViewModel)->
    params =
      adults: parseInt ViewModel.adults()
      children: if ViewModel.children() then parseInt ViewModel.children() else 0
      infant: if ViewModel.infant() then parseInt ViewModel.infant() else 0
      "class" : ViewModel.aviaClass()
      return_way: parseInt ViewModel.direction()
      currency: ViewModel.currency()
      avia_company: ViewModel.aviaCompany()
      best_price: if ViewModel.bestPrice() then 1 else 0
      direct_flights: if ViewModel.directFlights() then 1 else 0
    if ViewModel.complexSearch()
      cityCodes = []
      date = []
      _.each ViewModel.complexFields(), (o) ->
        cityCodes.push "#{o.cityFromCode()}-#{o.cityToCode()}"
        date.push o.date()
      params.city = cityCodes.join "_"
      params.date = date.join "_"
      url = Routing.generate "bundles_default_search_complex_search",params
    else
      params.city_from_code = ViewModel.cityFromCode()
      params.city_to_code = ViewModel.cityToCode()
      params.date_from = ViewModel.dateFrom()
      params.date_to = ViewModel.dateTo()
      url =  Routing.generate "bundles_default_api_list",params
    return url
