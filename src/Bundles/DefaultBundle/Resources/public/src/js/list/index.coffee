ko = require "knockout"
_ = require "underscore"
ViewModelBase = require "./../lib/search_form_model"
Route = require "./../lib/route"
require "./../lib/autocomplete"
require "./../lib/datepicker"
require "./../lib/validate"
Paginator = require "./pager"

routeCreator = new Route
pager = new Paginator
class ViewModel extends ViewModelBase
  constructor:(requestHandler) ->
    super()
#    @viewCalendar = !!@bestPrice()
    @viewCalendar = false
    @hasNext = ko.observable false
    @getNext = ->
      pager.getItems this, requestHandler
$(->
  requestHandler = (res) ->
    vm.hasNext !!res.hasNext
    $('#result-box').append res.html
    $('#search-result-box').html res.filter_form
    _GlobalAppObject.loadingStop()

  vm = new ViewModel(requestHandler)
  ko.applyBindings vm
  setTimeout ->
    pager.getItems vm, requestHandler
#    if vm.viewCalendar
#      filterForm = $("#filter-form").serializeArray()
#      url = routeCreator.createComplexCalendar vm
#      $.post url, filterForm, (data) ->
#        $("#avia-calendar-box").html data
#        return
  , 300
  $('body').on 'change', '#filter-form', ->
    pager.clear().getItems vm, (res) ->
      vm.hasNext !!res.hasNext
      $('#result-box').html res.html
      $('#search-result-box').html res.filter_form
      _GlobalAppObject.loadingStop()

#  bundles_default_api_complex_calendar
)
