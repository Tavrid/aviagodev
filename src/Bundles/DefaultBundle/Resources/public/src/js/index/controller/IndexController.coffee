SearchForm = require "../model/searchForm"

module.exports = [
  '$scope',
  '$rootScope',
  (scope,rootScope) ->
    rootScope.workedController = 'index'
    scope.searchForm = new SearchForm
]
