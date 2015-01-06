ko = require "knockout"
_ = require "underscore"
require "./../lib/autocomplete"
require "./../lib/datepicker"
require "./../lib/validate"
ViewModel = require "./../lib/search_form_model"

$(->
  vm = new ViewModel
  ko.applyBindings vm
)
