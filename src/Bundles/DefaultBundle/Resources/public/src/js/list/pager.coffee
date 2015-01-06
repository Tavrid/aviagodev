Route = require "./../lib/route"
routeCreator = new Route
module.exports = class
  p = 0
  clear: ->
    p = 0
    return this
  getItems: (viewModel,callback) ->
    p++
    _GlobalAppObject.loadingStart()
    data = $('#filter-form').serializeArray()
    $.getJSON(routeCreator.createComplexSearchItems(viewModel,{page: p}),data, callback)
    .error(->
      _GlobalAppObject.loadingStop();
    )
