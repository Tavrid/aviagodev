
_ = require "underscore"

scopePrepare = require "../../util/scopeUtils"


module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer'
  '$viewLoader'
  '$stateParams'
  (scope, http, location, AutoCompleteReplacer,viewLoader,stateParams) ->
    scopePrepare scope
    viewLoader.showLoader()
    scope.book_info = null;
    scope.ticket = {}
    http.get Routing.generate('api_order_get_data', {orderId: stateParams.orderId})
      .success (res) ->
        viewLoader.hideLoader()
        scope.book_info = res.book_info
        scope.ticket = res.book_info.ticket





]
