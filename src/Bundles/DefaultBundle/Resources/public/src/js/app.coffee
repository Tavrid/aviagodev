require "angular"
require "angular-ui-router"
datepicker = require "./datepicker"
formUtil = require "./util/postForm"


BookController = require('./book/controller/BookController')
SearchController = require './search/controller/SearchController'
OrderController = require './order/controller/OrderController'
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

App.factory '$viewLoader',["$rootScope",(rootScope)->
  rootScope.showLoader = true
  {
    showLoader: () ->
      rootScope.showLoader = true
    hideLoader: () ->
      rootScope.showLoader = false
  }
]
App.factory '$formHelper', formUtil

App.directive 'autoComplete', require "./lib/ngAutocomplete"
App.directive 'ngDatepicker', datepicker

App.config [
  '$stateProvider'
  '$locationProvider'
  ($stateProvider, $locationProvider) ->
    $locationProvider.html5Mode(true)

    $stateProvider.state('searchList',
      templateUrl: '/build/view/search/search.html'
      url: '/flights/*path'
      controller: SearchController
    )
    .state('book',
      templateUrl: '/build/view/book/book.html'
      url: '/book/:requestId'
      controller: BookController
    )
    .state('order',
      templateUrl: '/build/view/order/order.html'
      url: '/order/:orderId'
      controller: OrderController
    )
]