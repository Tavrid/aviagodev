###
  Form params resolver
###
_ = require "underscore"
getFormParams = (formData)->

  formPar = []

  getFullNameRecursive = (data) ->
    if data instanceof Object
      if typeof data.full_name != "undefined" && typeof  data.full_name != "id"
        formPar.push "#{encodeURIComponent data.full_name}=#{encodeURIComponent data.value || data.data}" if data.data
      else
        _.each data, (num) ->
          getFullNameRecursive num

  getFullNameRecursive formData
  return formPar.join '&'

module.exports = [
  '$http',
  (http) ->
    return {
      post: (url, data) ->
        return http
          method: 'POST',
          url: url,
          data: getFormParams(data),
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}

    }

]