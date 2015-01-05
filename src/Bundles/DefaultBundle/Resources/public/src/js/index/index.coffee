ko = require "knockout"
_ = require "underscore"
require "./ko_autocomplete"
require "./datepicker"
require "./validate"
ViewModel = require "./search_form_model"




$(->
  vm = new ViewModel
  ko.applyBindings vm
)
