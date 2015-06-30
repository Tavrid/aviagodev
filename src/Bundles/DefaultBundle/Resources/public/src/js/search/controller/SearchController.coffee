#SearchForm = require "../model/searchForm"

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer',
  (scope, http, location, AutoCompleteReplacer) ->
    scope.$root.appCont = 'search'
    console.log 'search'
]
