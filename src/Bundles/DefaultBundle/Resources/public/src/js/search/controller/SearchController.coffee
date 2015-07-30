SearchForm = require "../../model/searchForm"
propPath = require 'property-path'
_ = require "underscore"

scopePrepare = require "../../util/scopeUtils"


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
    scopePrepare scope
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
    scope.searchForm = {}



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
