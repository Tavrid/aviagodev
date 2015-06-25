require "angular"
require "angular-ui-router"


IndexController = require('./index/controller/IndexController')
#$ ->
App = angular.module "MainApp", ['ui.router']



App.controller 'SearchFormCtrl', IndexController
App.directive 'autoComplete', require "./lib/ngAutocomplete"

App.config [
  '$stateProvider'
  '$locationProvider'
  ($stateProvider,$locationProvider) ->
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
