require "angular"
require "angular-ui-router"
IndexController = require('./index/controller/IndexController')
#$ ->
App = angular.module "MainApp", ['ui.router']

#  console.log(scope)

App.controller 'SearchFormCtrl', IndexController

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
