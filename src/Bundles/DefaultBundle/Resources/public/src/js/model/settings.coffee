module.exports =  (App) ->

  App.controller 'settingsCtrl',[
    '$scope',
    '$http',
    (scope,http) ->
      scope.isShowSettingsBox = false
      scope.languages = global.appConfig.languages
      scope.currencies = global.appConfig.currencies
      scope.language = global.appConfig.lang
      scope.currency = global.appConfig.currency

      ###
        change lang
      ###
      scope.changeLang = () ->
        url = Routing.generate 'api_settings_get_change_locale', {'locale': scope.language}
        http.get url
        .success ->
          window.location.reload()
      ###
        change currency
      ###
      scope.changeCurrency = () ->
        url = Routing.generate 'api_settings_get_change_currency', {'currency': scope.currency}
        http.get url
        .success ->
          window.location.reload()

      ###
      show language and currency dropdown
      ###
      scope.showSettingsBox = ->
        scope.isShowSettingsBox = !scope.isShowSettingsBox

      ###
        return language name
      ###
      scope.currentLanguageName= () ->
        scope.languages[scope.language]

      ###
        return language
      ###
      scope.currentLanguage= () ->
        scope.language

      ###
        return language name
      ###
      scope.currentCurrencyName= () ->
        scope.currencies[scope.currency]

      ###
        return language
      ###
      scope.currentCurrency= () ->
        scope.currency
]
