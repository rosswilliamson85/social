$(document).ready(function() {

    $(document).on('click', '#post-btn', function() {
      var content = $('#content').val();
      var username = $('#username').val();
      var form_token = $('#form_token').val();
  
      if (content !== "") {
        $('#profile-post').css('border', '2px solid black');
        $.post('/posts', { form_token: form_token, username: username, content: content }, function(data) {

            
            $('.post_data').html(data);
          

          $('#content').val('');
         
          
        });
      } else {
        $('#profile-post').css('border', '2px solid red');
      }
    });
  
    $(document).on('click', '[id^="delete-post-btn"]', function() {
      var form_token = $('#form_token').val();
      var button_id = $(this).attr('id').replace('delete-post-btn', '');
  
      
      $.post('/delete/post', { form_token: form_token, button_id: button_id }, function(data) {
        $('.display_post' + button_id).css('visibility','hidden');
        $('.display_post' + button_id).html(data);
      });
    });
  
  });
  