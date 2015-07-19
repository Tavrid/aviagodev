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

    http.get Routing.generate 'api_get_tickets', {page: 1,path: location.path().replace(/\/+/g,'__')}
    .success (res) ->
      scope.searchForm = new SearchForm res.formParams
      prepareTickets res.tickets
      scope.tickets = res.tickets
      viewLoader.hideLoader()
    .error () ->
      viewLoader.hideLoader()


    scope.$root.appCont = 'search'
    scope.dateFormat = dateFormatter
    scope.searchForm = {}
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

    scope.book = (ticket) ->
      variants = []
      data =
        request_id : ticket.request_id
      _.each ticket.itineraries, (itinerarie) ->

        findVariant = _.find itinerarie.variants , (variant) ->
          variant.checked
        variants.push findVariant.variant_id

      data.variants = variants.join ','

      viewLoader.showLoader()

      http.post Routing.generate 'api_post_ticket_info', data
        .success (res) ->
          location.state {foo:'bar'}
          location.path res.url.replace /\/app_dev.php/,""
        .error () ->
          viewLoader.hideLoader()
    scope.reverse = ->
      AutoCompleteReplacer.reverse()







]
