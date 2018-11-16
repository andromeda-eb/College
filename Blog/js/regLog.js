$(document).ready(function(){

  $(window).on('scroll', function(){

    if($(window).scrollTop())
      $('.stickyNav').addClass('black');

    else
      $('.stickyNav').removeClass('black');

  });

  function readURL(input) { // function for previewing avatar image for registration ( with png validation )
    var fileName = document.getElementById("image").value;

    if (fileName.split(".")[1].toUpperCase() == "PNG"){ // if extension is png

        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function(e) { // onload change the target to the input image
                $('#preview').attr('src', e.target.result);

            }

          reader.readAsDataURL(input.files[0]);
        }

    }else
      $('#preview').removeAttr('src'); // removes image attribute otherwise

  }

  $("#image").change(function() { // initiates when image is loaded on registration page
      readURL(this);
  });

  function errorMessage(target, errorMessage, color){

    $(target).text(
      errorMessage).css(
      'color', color,
      'transition', '.8s').effect(
      "shake", {
        times: 4,
        distance: 10
        },
        1000
      );
  }
  
  $("#register").click(function(event){

     var success;
     var invalidDetails = $('#username').val() == '' || $('#email').val() == '' || $('#password').val() == '';
      $.ajax({

      url:"../php/regLog.php",
      data:{
        function: 'register',
        username: $('#username').val(),
        email: $('#email').val()
      },
      dataType:'json',
      method:'POST',
      async:false, // set async to false to allow variable assignments in ajax
      success:function(data){
         
        if(invalidDetails == true)
          errorMessage($('.regLogError'), "Valid details must be supplied", '#FF0033');
        else if(data.username || data.email)
          errorMessage($('.regLogError'), "Details already exist in the databse", '#FF0033');
        else
          success = true;

      }
    });

      if( success == true)
        //errorMessage($('.regLogError'), "Registration success", '#4BB543');
        alert('Registration success');
      else
        event.preventDefault();
  });

  $("#login").click(function(event){ 
    
    var success = false;
    var invalidDetails = $('#username').val() == '' || $('#email').val() == '' || $('#password').val() == '';
      $.ajax({

        url:"../php/regLog.php",
        data:{
          function: 'login',
          username: $("#username").val(),
          email:$("#email").val(), 
          password: $("#password").val() 
        },
        dataType:'text',
        method:'POST',
        async:false, // used for returning value from this function
        success:function(data){

          if( invalidDetails == true)
            errorMessage($('.regLogError'), "Valid details must be supplied", '#FF0033');
          else if(!data)
            errorMessage($('.regLogError'), "No matching details have been found", '#FF0033');
          else
            success = true;

        }
    });

      if(success == true)
        alert("login success");
      else
        event.preventDefault();
    });

    $('.indexBox').animate({"margin-left": '0%'},880); // animates the boxes in index

    $('.createBoxWrapper').animate({"margin-top": '0%'},880); // animates the create blog box

 
 });
