ko = require "knockout"
_ = require "underscore"
ViewModelBase = require "./../lib/search_form_model"
Route = require "./../lib/route"
require "./../lib/autocomplete"
require "./../lib/datepicker"
require "./../lib/validate"

routeCreator = new Route

class ViewModel extends ViewModelBase
  constructor: ->
    super()
    @viewCalendar = !!@bestPrice()
$(->
  vm = new ViewModel
  ko.applyBindings vm
  console.log routeCreator.createSearch vm
)
