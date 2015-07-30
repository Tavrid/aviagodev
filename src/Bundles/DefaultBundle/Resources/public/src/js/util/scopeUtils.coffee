moment = require "moment"
propPath = require 'property-path'
_ = require "underscore"


module.exports = (scope) ->
  scope.dateFormat = (timestamp, format = "D.MM.YYYY") ->
    moment.unix(timestamp).format format
  ###
      get Departure Segment
    ###
  scope.departureSegment = (variant) ->
    if propPath.get variant, "segments.0"
      return propPath.get variant, "segments.0"
    {}

  ###
    get Arrival segment
  ###
  scope.arrivalSegment = (variant) ->
    if variant.segments != undefined
      return _.last variant.segments
    {}


    ###
        select current variant
        and un check others variants
      ###
  scope.selectVariant = (() ->
    (variant,variants) ->
      if variant.checked
        return

      _.each variants, (num) ->
        num.checked = false

      variant.checked = true
  )()

  scope.toggleCheckbox= (parent,child) ->
    newChildVal = !child.data
    _.each parent, (ch) ->
      ch.data = false
    child.data = newChildVal