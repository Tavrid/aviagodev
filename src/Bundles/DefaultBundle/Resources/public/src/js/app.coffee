require "angular"
require "angular-ui-router"


IndexController = require('./index/controller/IndexController')
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

App.controller 'SearchFormCtrl', IndexController
App.directive 'autoComplete', require "./lib/ngAutocomplete"

App.config [
  '$stateProvider'
  '$locationProvider'
  ($stateProvider, $locationProvider) ->
    $locationProvider.html5Mode(true)
    #    $stateProvider.state('searchForm',
    #      templateUrl: '/build/view/index/index.html'
    #      controller: IndexController
    #      url: '/'
    #    )
    $stateProvider.state('searchList',
      templateUrl: '/build/view/index/index.html'
      url: '/flights/*path'
      controller: ->
        console.log 'search controller'
    )
    return
]
