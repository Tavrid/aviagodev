moment = require "moment"
propPath = require 'property-path'
_ = require "underscore"
secondsToTime = require "./secondToTime"


module.exports = (scope) ->

  scope.translator = global.Translator
  scope.formatPrice = (number, decimals = 0, dec_point=" ", thousands_sep=" ") ->

    number = (number + "").replace(/[^0-9+\-Ee.]/g, "")
    n = (if not isFinite(+number) then 0 else +number)
    prec = (if not isFinite(+decimals) then 0 else Math.abs(decimals))
    sep = (if (typeof thousands_sep is "undefined") then "," else thousands_sep)
    dec = (if (typeof dec_point is "undefined") then "." else dec_point)
    s = ""
    toFixedFix = (n, prec) ->
      k = Math.pow(10, prec)
      "" + (Math.round(n * k) / k).toFixed(prec)


    # Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = ((if prec then toFixedFix(n, prec) else "" + Math.round(n))).split(".")
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)  if s[0].length > 3
    if (s[1] or "").length < prec
      s[1] = s[1] or ""
      s[1] += new Array(prec - s[1].length + 1).join("0")
    s.join dec

  scope.secondsToTime = (seconds) ->
    time = secondsToTime seconds
    returnStr = ""
    if time.h
      returnStr+="#{time.h} h"
    if time.m
      returnStr+=" #{time.m} m"
    if time.s
      returnStr+=" #{time.s} s"
    return returnStr

  getMoment = (date) ->
    if typeof date == "number"
      return moment.unix(date)
    else
      return moment(date)
  ###
  date format
  ###
  scope.dateFormat = (date, format = "DD.MM.YYYY") ->
    getMoment(date).format format
  ###
  dif dates
  ###
  scope.dateDiff = (d1,d2, diffOf = 'days') ->
    getMoment(d1).diff(getMoment(d2),diffOf)
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
  ## pricing by name
  scope.getPricingByName = (ticket,traveler) ->
    _.find ticket.pricing, (num) ->
      num.Type == traveler
  scope.toggleCheckbox= (parent,child) ->
    parent.data = child.data