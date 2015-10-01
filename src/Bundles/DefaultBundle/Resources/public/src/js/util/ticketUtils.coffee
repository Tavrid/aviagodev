
module.exports = (scope) ->

  scope.getTicketTypeName = (ticket) ->

    if ticket.itineraries.length == 1
      return Translator.trans "frontend.default.order.one_way"
    else if ticket.itineraries.length == 2
      return Translator.trans "frontend.default.order.two_way"
    else
      return "multiple"