$(document).ready(function(){

	if(location.pathname.split("/").slice(-1) == 'viewBlog.php') {// only applies this function if pagename is viewBlog.php
		loadComments();
		enableComments();
		$('.viewBox').animate({"margin-top": '0%'},880); 
	}

	function errorMessage(target, errorMessage, color){

    $(target).text(
      errorMessage).css(
      'color', color,
      'transition', '.8s').effect(
      "shake", {
        times: 3,
        distance: 10
        },
        1000
      );
  }

	$('.commentPostBtnWrapper').on('click', function(){

		var blackList = ['apples', 'ban'];
		var blackListedVal = '';

		for(var i = 0; i < blackList.length; i++) // checks if word is in black list
			if( $('.commentInsertText').val().includes(blackList[i]) )
				blackListedVal += blackList[i] + ' / ';

		if($('#commentPostText').val() == '')
			errorMessage($('.error'), 'Comment Box cannot be empty', '#FF0033');
		else if( blackListedVal !== '' )
			errorMessage($('.error'), 'You\'ve included a  blackListed word(s) : ' + blackListedVal, '#FF0033');
		else{
			insertComment();
			$('.error').text('Comment success').css('color', '#4BB543');
		}
		
	});

	function insertComment(){
		$.ajax({
			url:'../php/comments.php',
			method:'POST',
			data:{
				function: 'insertComment',
				postId: $('#postId').val(),
				username: $('#username').val(),
				date: $('#date').val(),
				comment: $('#commentPostText').val()
			},
			dataType:'text',
			success:function(data){
				$('.commentsHolder-ul').prepend(data);
				$('.commentInsertText').val("");
			}
		});
	}

	function loadComments(){

		$.ajax({
			url:'../php/comments.php',
			method:'POST',
			data:{
				function: 'loadComments',
				postId: $('#postId').val()
			},
			dataType:'text',
			success:function(data){
				$('.commentsHolder-ul').prepend(data);
			}
		});
	}

	$('.checkbox').on('click', function(){
		var enable;

		if($('.checkbox').is(':checked'))
			enable = 1;
		else
			enable = 0;

		var enableMessage = ('Comments have been ' + ((enable == 1)? 'enabled' : 'disabled'));
		var enableMessageColor = (enable == 1) ? '#4BB543' : '#FF0033';

		$.ajax({
			url:'../php/comments.php',
			method:'POST',
			data:{
				function:'enableComments',
				postId: $('#postId').val(),
				enableComments:enable
			},
			dataType: 'text',
			success:function(data){
				$('.error').text(enableMessage).css('color', enableMessageColor);
				enableComments();
			}
		});
					
	});

	function enableComments(){
		$.ajax({
			url:'../php/comments.php',
			method:'POST',
			data:{
				function:'checkEnable',
				postId: $('#postId').val(),
			},
			dataType: 'text',
			success:function(data){
				if( data == 0){
					$('.commentPostBtnWrapper').prop('disabled', true);
					errorMessage($('.error'), 'Comments have been disabled', '#FF0033');
				}else{
					$('.commentPostBtnWrapper').prop('disabled', false);
					$('.checkbox').prop('checked', true); 
					errorMessage($('.error'), 'Comments have been enabled', '#4BB543');
				}
			}
		});
	}

});