objectPath = require "object-path"
_ = require "underscore"

class MatchItem
  constructor: (@code,@formattedName, @parent = true) ->
module.exports =
  [
    '$timeout',
    '$http'
    (timeout,http) ->
      searchCache = {}
      fromAttr = null
      replace: true
      scope: {}
      templateUrl: 'auto-complete.html'
      link: (scope, element, attr)->

        $ document
          .click (e)->
            if scope.mathes.length
              scope.$apply ->
                scope.mathes = []

        currentTimer = null
        scope.attr = {id: attr.attrId, placeholder: attr.attrPlaceholder}
        scope.clickItem = (index) ->

          scope.query = scope.mathes[index].formattedName
          scope.code = scope.mathes[index].code
          objectPath.set scope, attr.insertTo, scope.mathes[index].code
          scope.mathes = []

        scope.search = ->
          if !scope.query || scope.query.length < attr.searchLength
            scope.mathes = []
            return
          timeout.cancel currentTimer
          if searchCache[scope.query] == undefined
            currentTimer = timeout ->
              http.get(Routing.generate("bundles_default_search_city",{q: scope.query })).then((result) ->
                mathes = []
                _.each result.data , (num) ->
                  mathes.push(new MatchItem num.id, "#{num.country}, #{num.name}")
                  if num.child
                    _.each num.child, (child) ->
                      mathes.push(new MatchItem child.code, "#{child.airport}, #{child.name}", false)

                searchCache[scope.query] = mathes
                scope.mathes = searchCache[scope.query];
              )
            , 150
          else
            scope.mathes = searchCache[scope.query]
        fromAttr =  objectPath.get scope, attr.searchFrom, null
      controller: [
        '$scope'
        (scope) ->
          scope.mathes = []

      ]
  ]
