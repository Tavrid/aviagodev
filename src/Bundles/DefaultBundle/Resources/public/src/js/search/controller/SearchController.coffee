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
  '$stateParams',
  'SearchForm'
  (scope, http, location, AutoCompleteReplacer,viewLoader,stateParams,searchForm) ->
    scopePrepare scope

    scope.viewSearchForm = false
    ###
      view loader
    ###
    viewLoader.showLoader()

    http.get Routing.generate 'api_get_tickets', {page: 1,key: stateParams.key}
    .success (res) ->
      scope.searchForm = searchForm.createForm res.form
      prepareTickets res.tickets
      scope.tickets = res.tickets
      viewLoader.hideLoader()
      scope.viewSearchForm = true
      AutoCompleteReplacer.initScopes()
    .error () ->
      viewLoader.hideLoader()
      AutoCompleteReplacer.initScopes()

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
