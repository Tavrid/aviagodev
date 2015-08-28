###
  Form params resolver
###
_ = require "underscore"
getFormParams = require "./formParams"

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