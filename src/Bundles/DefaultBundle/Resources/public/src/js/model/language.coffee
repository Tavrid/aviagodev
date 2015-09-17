module.exports =  (App) ->

  App.controller 'languageCtrl',[
    '$scope',
    '$http',
    (scope,http) ->
      scope.isShowLanguageBox = false
      scope.languages = global.appConfig.languages
      scope.language = global.appConfig.lang

      ###
        change lang
      ###
      scope.changeLang = () ->
        url = Routing.generate 'api_settings_get_change_locale', {'locale': scope.language}
        http.get url
        .success ->
          window.location.reload()

      ###
      show language and currency dropdown
      ###
      scope.showLanguageBox = ->
        scope.isShowLanguageBox = !scope.isShowLanguageBox
      ###
        return language name
      ###
      scope.currentLanguageName= () ->
        global.appConfig.languages[global.appConfig.lang]
      ###
        return language
      ###
      scope.currentLanguage= () ->
        global.appConfig.lang
]