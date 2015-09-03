#TODO this controller need refactoring!!!
propPath = require 'property-path'
_ = require "underscore"

scopePrepare = require "../../util/scopeUtils"
getFormParams = require "../../util/formParams"


prepareTickets = (tickets) ->
  _.each tickets, (ticket) ->
    _.each ticket.itineraries, (itinerarie) ->
      propPath.set itinerarie, 'variants.0.checked', true

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer'
  '$viewLoader'
  '$stateParams',
  'SearchForm'
  (scope, http, location, AutoCompleteReplacer, viewLoader, stateParams, searchForm) ->
    scopePrepare scope
    page = 1
    searchUrlName = 'api_get_tickets'
    scope.viewSearchForm = false
    scope.viewFilterForm = false
    ###
      view loader
    ###
    viewLoader.showLoader()

    http.get Routing.generate searchUrlName, {page: page, key: stateParams.key}
    .success (res) ->
      scope.searchForm = searchForm.createForm res.form
      prepareTickets res.tickets
      scope.tickets = res.tickets
      viewLoader.hideLoader()
      scope.viewSearchForm = true

      if(res.filter_form)
        scope.viewFilterForm = true
        scope.filterForm = res.filter_form

    .error () ->
      viewLoader.hideLoader()

    scope.$root.appCont = 'search'
    scope.searchForm = {}

    scope.loadItems = ()->
      page = 1
      params = ["key=#{stateParams.key}"]
      _.each scope.filterForm, (num) ->
        _.each num.choices, (choice) ->
          if choice.selected
            tmVal = "#{encodeURIComponent num.full_name}=#{encodeURIComponent choice.value}"
            params.push tmVal
      viewLoader.showLoader()
      http
        method: 'GET',
        url:  Routing.generate(searchUrlName, {page: page})+"?"+params.join('&'),
      .success (res) ->
        if res.tickets.length
          prepareTickets res.tickets
          scope.tickets = scope.tickets.concat res.tickets
        else
          scope.tickets = []
          scope.hideLoadMoreButton = true
        viewLoader.hideLoader()
      .error ->
        viewLoader.hideLoader()

    scope.more = ->
      page++
      viewLoader.showLoader()
      http.get Routing.generate searchUrlName, {page: page, key: stateParams.key}
      .success (res) ->
        if res.tickets.length
          prepareTickets res.tickets
          scope.tickets = scope.tickets.concat res.tickets
        else
          scope.hideLoadMoreButton = true
        viewLoader.hideLoader()

      .error () ->
        viewLoader.hideLoader()
    scope.search = ->
      scope.searchForm.getUrl (url) ->
        location.path url.replace /\/app_dev.php/, ""
      return false

    scope.book = (ticket) ->
      variants = []
      data =
        request_id: ticket.request_id
      _.each ticket.itineraries, (itinerarie) ->
        findVariant = _.find itinerarie.variants, (variant) ->
          variant.checked
        variants.push findVariant.variant_id

      data.variants = variants.join ','

      viewLoader.showLoader()

      http.post Routing.generate 'api_post_ticket_info', data
      .success (res) ->
        location.path res.url.replace /\/app_dev.php/, ""
      .error () ->
        viewLoader.hideLoader()
    scope.reverse = ->
      AutoCompleteReplacer.reverse()


]
