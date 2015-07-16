SearchForm = require "../../model/searchForm"
propPath = require 'property-path'
moment = require "moment"
dateFormatter = (timestamp, format = "D.MM.YYYY") ->
  moment.unix(timestamp).format format

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer',
  (scope, http, location, AutoCompleteReplacer) ->
    scope.$root.appCont = 'search'
    scope.searchForm = new SearchForm global.formValues
    scope.dateFormat = dateFormatter

    scope.departureSegment = (itinerarie) ->
      if propPath.get itinerarie, "variants.0.segments.0"
        return propPath.get itinerarie, "variants.0.segments.0"
      null

    ###
      TODO need fix!
    ###
    scope.arrivalSegment = (itinerarie) ->
      if propPath.get itinerarie, "variants.0.segments.0"
        return propPath.get itinerarie, "variants.0.segments.0"
      null
#    scope.arrivalSegment = (itinerarie)
#    if itinerarie.variants != undefined && itinerarie.variants[itinerarie.variants.length -1] && itinerarie.variants[itinerarie.variants.length -1].segments && itinerarie.variants[itinerarie.variants.length -1].segments[0]
#      return itinerarie.variants[0].segments[0]
#    null

    http.get Routing.generate 'bundles_default_api_flights_items', global.formValues
      .success (res) ->
        scope.tickets = res
    scope.reverse = ->
      AutoCompleteReplacer.reverse()
]
