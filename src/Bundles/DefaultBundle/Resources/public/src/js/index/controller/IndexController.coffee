SearchForm = require "../model/searchForm"

module.exports = [
  '$scope',
  '$http',
  (scope,http) ->


    scope.searchForm = new SearchForm
    scope.mathes = []
]
