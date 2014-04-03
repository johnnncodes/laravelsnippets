root = (exports ? window)

###############################################################################
## Views
###############################################################################
UpdateProfilePicView = Backbone.View.extend
  el: $('#profile-pic-section')

  render: ->
    $("#fileupload").fileupload(
      url: UPDATE_PHOTO_URL
      dataType: "json"

      add: (e, data) ->
        selectedImage = data.originalFiles[0]
        validImgTypes = ['image/jpeg', 'image/png', 'image/gif']
        twoMB = 2097152  # bytes

        if not _.contains(validImgTypes, selectedImage.type)
          alert 'Invalid image selected.'
          return

        if selectedImage.size > twoMB
          alert 'Image must not be more than 2mb.'
          return

        data.formData = _token: $("input[name='_token']").val()
        data.submit()

      start: (e) ->
        $('#update-profile-pic-span').addClass('hide')
        $('.please-wait-msg').removeClass('hide')

      done: (e, data) ->
        $('.please-wait-msg').addClass('hide')
        $('#update-profile-pic-span').removeClass('hide')
        $('#profile-pic').attr('src', data.result.photo_url)

    ).prop("disabled", not $.support.fileInput)
     .parent()
     .addClass (if $.support.fileInput then `undefined` else "disabled")


LaraSnipp.User =
  UpdateProfilePicView: UpdateProfilePicView

$ ->
  "use strict"

  if $('#update-profile-pic-span').length > 0
    LaraSnipp.updateProfilePicView = new LaraSnipp.User.UpdateProfilePicView()
    LaraSnipp.updateProfilePicView.render()