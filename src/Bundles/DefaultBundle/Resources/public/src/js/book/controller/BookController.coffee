
moment = require "moment"
_ = require "underscore"

scopePrepare = require "../../util/scopeUtils"
ticketUtils = require "../../util/ticketUtils"
Object.deepExtend = (destination, source) ->
  for property of source

    if source[property] && (typeof source[property] == 'object' || typeof source[property] == 'function')
      destination[property] = destination[property] or {}
      arguments.callee destination[property], source[property]
    else
      destination[property] = source[property]
  destination
###
###
prepareFormData = (data) ->
  _.each data, (property) ->
    if property && property.errors != undefined
      property.errors = []
    else if property && typeof property != 'string' && typeof property != 'number' && typeof property != 'boolean'
      prepareFormData property
  return

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer'
  '$viewLoader'
  '$stateParams'
  '$formHelper'
  '$sce'
  'ngDialog'
  (scope, http, location, AutoCompleteReplacer,viewLoader,stateParams,formHelper,sce,ngDialog) ->
    scopePrepare scope
    ticketUtils scope

    scope.tickets = []
    scope.form = {}
    scope.fareRules = ''


    scope.book = () ->
      viewLoader.showLoader()
      formHelper
        .post(Routing.generate('api_book_post_create', {key: stateParams.requestId}),scope.form)
          .success (res) ->
            prepareFormData scope.form
            Object.deepExtend scope.form, res.form
            viewLoader.hideLoader()
            if res.is_valid
              location.path res.url.replace /\/app_dev.php/,""
          .error  ->
            viewLoader.hideLoader()

    ## current travelers

    scope.getCurrentTravelers = (ticket) ->
      travelers = []
      _.each ticket.travelers, (key,num) ->
        travelers.push num if key > 0
      return travelers

    ###
      get avia fare rules
    ###
    scope.getFareRules = () ->
      viewLoader.showLoader()
      http.get Routing.generate 'api_book_get_fare_rules', {key: stateParams.requestId}
      .success (res) ->
        viewLoader.hideLoader()
#        sce.trustAsHtml(val)
        fareRules = ''
        _.each res.avia_fare_rules,(rules) ->
          _.each rules, (rule) ->
            fareRules+=rule

        scope.fareRules = sce.trustAsHtml fareRules
        ngDialog.open({ template: '<pre>'+fareRules+'</pre>', plain: true })
      .error ->
        viewLoader.hideLoader()

    ###
    pricing by name
    ###
    scope.getPricingByName = (ticket,traveler) ->
      _.find ticket.pricing, (num) ->
        num.Type == traveler
    ## get initialize data
    http.get Routing.generate 'api_book_get_data', {key: stateParams.requestId}
      .success (res) ->
        viewLoader.hideLoader()
        scope.tickets.push res.data.ticket
        scope.form =  res.form



]
