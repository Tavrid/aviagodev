objectPath = require "object-path"
_ = require "underscore"

class MatchItem
  constructor: (@code,@formattedName, @parent = true) ->

createListMatches = (data, query) ->
  matches = []

  _.each data , (num) ->
    if (num.code.search new RegExp query, 'ig') != -1 || (num.airport.search new RegExp query, 'ig') != -1
      matches.push(new MatchItem num.id, "#{num.airport}, #{num.name}")
    else
      matches.push(new MatchItem num.id, "#{num.country}, #{num.name}")
    if num.child
      _.each num.child, (child) ->
        matches.push(new MatchItem child.code, "#{child.airport}, #{child.name}", false)
  return matches

module.exports =
  [
    '$timeout',
    '$http',
    'AutoCompleteReplacer'
    (timeout,http, AutoCompleteReplacer) ->
      searchCache = {}
      fromAttr = null
      replace: true
      scope: {}
      templateUrl: 'auto-complete.html'
      link: (scope, element, attr)->
        if attr.reverseComponent
          AutoCompleteReplacer.addAutoCompleteScope scope

        $ document
          .click (e)->
            if scope.matches.length
              scope
              .$apply ->
                scope.matches = []

        currentTimer = null
        scope.attr = {id: attr.attrId, placeholder: attr.attrPlaceholder}
#        scope.updateModel = ->
#          bjectPath.set scope, attr.insertTo, scope.matches[index].code

        scope.clickItem = (index) ->

          scope.query = scope.matches[index].formattedName
          scope.code = scope.matches[index].code
#          objectPath.set scope, attr.insertTo, scope.matches[index].code
          scope.matches = []

        scope.search = ->
          if !scope.query || scope.query.length < attr.searchLength
            scope.matches = []
            return
          timeout.cancel currentTimer
          if searchCache[scope.query] == undefined
            currentTimer = timeout ->
              http.get(Routing.generate("bundles_default_search_city",{q: scope.query })).then((result) ->

                searchCache[scope.query] = createListMatches result.data, scope.query
                scope.matches = searchCache[scope.query];
              )
            , 150
          else
            scope.matches = searchCache[scope.query]
        fromAttr =  objectPath.get scope, attr.searchFrom, null
      controller: [
        '$scope'
        (scope) ->
          scope.matches = []

      ]
  ]
