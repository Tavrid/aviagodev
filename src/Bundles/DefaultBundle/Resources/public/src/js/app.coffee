require "angular"
require "angular-ui-router"
datepicker = require "./datepicker"

IndexController = require('./index/controller/IndexController')
SearchController = require './search/controller/SearchController'
#$ ->
App = angular.module "MainApp", ['ui.router']

class AutoCompleteReplacer
  autoCompleteScopes = []

  @controllerScope = null
  addAutoCompleteScope: (scope) ->
    autoCompleteScopes.push scope
  reverse: ->

    tempScopeCode = autoCompleteScopes[1].code
    autoCompleteScopes[1].code = autoCompleteScopes[0].code
    autoCompleteScopes[0].code = tempScopeCode

    tempScopeQuery = autoCompleteScopes[1].query
    autoCompleteScopes[1].query = autoCompleteScopes[0].query
    autoCompleteScopes[0].query = tempScopeQuery



App.service 'AutoCompleteReplacer', AutoCompleteReplacer

App.directive 'autoComplete', require "./lib/ngAutocomplete"
App.directive 'ngDatepicker', datepicker

App.config [
  '$stateProvider'
  '$locationProvider'
  ($stateProvider, $locationProvider) ->
    $locationProvider.html5Mode(true)

    $stateProvider.state('index',
      url: '/'
      controller: IndexController
    ).state('searchList',
      templateUrl: '/build/view/search/search.html'
      url: '/flights/*path'
      controller: SearchController
    )
    return
]
