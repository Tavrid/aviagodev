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
  'AutoCompleteReplacer',
  (scope, http, location, AutoCompleteReplacer) ->
    scope.$root.appCont = 'search'
    scope.searchForm = new SearchForm global.formValues
    scope.dateFormat = dateFormatter

    ###
      select current variant
      and un check others variants
    ###
    scope.selectVariant = (() ->
      variants = {}
      (variant,ticket,index) ->
        if variant.checked
          return

        if variants[ticket.request_id] != undefined && variants[ticket.request_id][''+index] != undefined
          variants[ticket.request_id][''+index].checked = false
#
        variant.checked = true
        variants[ticket.request_id] = {}
        variants[ticket.request_id][''+index] = variant
    )()

    ###
      get Departure Segment
    ###
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
    global.formValues.page = 1
    http.get Routing.generate 'api_get_tickets', global.formValues
      .success (res) ->
        prepareTickets res
        scope.tickets = res
    scope.reverse = ->
      AutoCompleteReplacer.reverse()
]
