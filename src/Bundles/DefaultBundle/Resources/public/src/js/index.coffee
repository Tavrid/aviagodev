require "angular"
datepicker = require "./datepicker"

IndexController = require('./index/controller/IndexController')

App = angular.module "MainApp", []

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
App.controller 'IndexCtrl', IndexController
