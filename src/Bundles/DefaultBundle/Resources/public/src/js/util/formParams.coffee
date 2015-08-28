_ = require "underscore"
module.exports = (formData)->
  formPar = []

  getFullNameRecursive = (data) ->
    if data instanceof Object
      if typeof data.full_name != "undefined" && typeof  data.full_name != "id"
        formPar.push "#{encodeURIComponent data.full_name}=#{encodeURIComponent data.data}" if data.data
      else
        _.each data, (num) ->
          getFullNameRecursive num

  getFullNameRecursive formData
  return formPar.join '&'