
moment = require "moment"
_ = require "underscore"


module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer'
  '$viewLoader'
  (scope, http, location, AutoCompleteReplacer,viewLoader) ->
    viewLoader.hideLoader()




]
