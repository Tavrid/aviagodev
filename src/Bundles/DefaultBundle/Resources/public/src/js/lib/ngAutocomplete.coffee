objectPath = require "object-path"
module.exports =
  [
    '$timeout',
    '$http'
    (timeout,http) ->
      fromAttr = null
      replace: true
      templateUrl: 'auto-complete.html'
      link: (scope, element, attr)->
        currentTimer = null
        scope.$watch attr.searchFrom, (newVal, oldVal)->
          timeout.cancel currentTimer
          currentTimer = timeout ->
            http.get(Routing.generate("bundles_default_search_city",{q: newVal})).then((result) ->
              scope.mathes = result.data.slice(0,10);
            )
          , 500, false
        fromAttr =  objectPath.get scope, attr.searchFrom, null
      controller: [
        '$scope'
        (scope) ->
          scope.mathes = []

          return
      ]
  ]
