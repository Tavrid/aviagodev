_ = require "underscore"

scopePrepare = require "../../util/scopeUtils"

ticketUtils = require "../../util/ticketUtils"


module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer'
  '$viewLoader'
  '$stateParams'
  (scope, http, location, AutoCompleteReplacer, viewLoader, stateParams) ->
    scopePrepare scope
    ticketUtils scope

    viewLoader.showLoader()
    scope.book_info = null;
    scope.tickets = []

    scope.getCurrentTravelers = (ticket) ->
      travelers = []
      _.each ticket.travelers, (num, key) ->
        travelers.push key if num.length > 0
      return travelers

    http.get Routing.generate('api_order_get_data', {orderId: stateParams.orderId})
    .success (res) ->
      viewLoader.hideLoader()
      scope.book_info = res.book_info
      scope.tickets = [res.book_info.ticket]


]
