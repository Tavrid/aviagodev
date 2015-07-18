SearchForm = require "../../model/searchForm"
propPath = require 'property-path'
moment = require "moment"
_ = require "underscore"

dateFormatter = (timestamp, format = "D.MM.YYYY") ->
  moment.unix(timestamp).format format

prepareTickets = (tickets) ->
  _.each tickets, (ticket) ->
    _.each ticket.itineraries, (itinerarie) ->
      propPath.set itinerarie,'variants.0.checked', true

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer'
  '$viewLoader'
  (scope, http, location, AutoCompleteReplacer,viewLoader) ->
    ###
      view loader
    ###
    viewLoader.showLoader()

    scope.$root.appCont = 'search'
    scope.searchForm = new SearchForm global.formValues
    scope.dateFormat = dateFormatter

    ###
      select current variant
      and un check others variants
    ###
    scope.selectVariant = (() ->
      (variant,variants) ->
        if variant.checked
          return

        _.each variants, (num) ->
          num.checked = false

        variant.checked = true
    )()

    ###
      get Departure Segment
    ###
    scope.departureSegment = (variant) ->
      if propPath.get variant, "segments.0"
        return propPath.get variant, "segments.0"
      {}

    ###
      get Arrival segment
    ###
    scope.arrivalSegment = (variant) ->
      if variant.segments != undefined
        return _.last variant.segments
      {}

    ###
      find default tickets
    ###
    global.formValues.page = 1

    http.get Routing.generate 'api_get_tickets', global.formValues
      .success (res) ->
        prepareTickets res
        scope.tickets = res
        viewLoader.hideLoader()
      .error () ->
        viewLoader.hideLoader()
    scope.reverse = ->
      AutoCompleteReplacer.reverse()
]
