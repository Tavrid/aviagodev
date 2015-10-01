
module.exports = (scope) ->

  scope.getTicketTypeName = (ticket) ->

    if ticket.itineraries.length == 1
      return Translator.trans "frontend.default.order.one_way"
    else if ticket.itineraries.length == 2
      return Translator.trans "frontend.default.order.two_way"
    else
      return "multiple"

  scope.getVariantTypeName = (variant) ->

    if variant.count_transplant == 0
      return Translator.trans "frontend.default.order.direct_flight"
    else
      return Translator.transChoice("frontend.default.list.item.transplant", variant.count_transplant,{count: variant.count_transplant})