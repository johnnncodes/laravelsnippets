(function() {
  var UpdateProfilePicView, root;

  root = typeof exports !== "undefined" && exports !== null ? exports : window;

  UpdateProfilePicView = Backbone.View.extend({
    el: $('#profile-pic-section'),
    render: function() {
      return $("#fileupload").fileupload({
        url: UPDATE_PHOTO_URL,
        dataType: "json",
        add: function(e, data) {
          var selectedImage, twoMB, validImgTypes;
          selectedImage = data.originalFiles[0];
          validImgTypes = ['image/jpeg', 'image/png', 'image/gif'];
          twoMB = 2097152;
          if (!_.contains(validImgTypes, selectedImage.type)) {
            alert('Invalid image selected.');
            return;
          }
          if (selectedImage.size > twoMB) {
            alert('Image must not be more than 2mb.');
            return;
          }
          data.formData = {
            _token: $("input[name='_token']").val()
          };
          return data.submit();
        },
        start: function(e) {
          $('#update-profile-pic-span').addClass('hide');
          return $('.please-wait-msg').removeClass('hide');
        },
        done: function(e, data) {
          $('.please-wait-msg').addClass('hide');
          $('#update-profile-pic-span').removeClass('hide');
          return $('#profile-pic').attr('src', data.result.photo_url);
        }
      }).prop("disabled", !$.support.fileInput).parent().addClass(($.support.fileInput ? undefined : "disabled"));
    }
  });

  LaraSnipp.User = {
    UpdateProfilePicView: UpdateProfilePicView
  };

  $(function() {
    "use strict";
    if ($('#update-profile-pic-span').length > 0) {
      LaraSnipp.updateProfilePicView = new LaraSnipp.User.UpdateProfilePicView();
      return LaraSnipp.updateProfilePicView.render();
    }
  });

}).call(this);
