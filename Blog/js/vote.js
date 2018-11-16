$(document).ready(function(){

	if(location.pathname.split("/").slice(-1) == 'profile.php')
		loadVotes();

	$('.like').on('click', function(){
		votePost(1);
	});

	$('.dislike').on('click', function(){
		votePost(0);
	});

	function votePost(argument){

		$.ajax({
			url:'../php/vote.php',
			method: 'POST',
			data: {
				function: 'votePost',
				vote: argument,
				postId: $('#postId').val(),
				userId: $('#userId').val()
			},
			dataType:'text',
			success:function(data){
				loadVotes();
			}

		});

	}

	function loadVotes(){

		$.ajax({
			url:'../php/vote.php',
			method: 'POST',
			data: {
				function: 'loadVotes',
				postId: $('#postId').val(),
			},
			dataType:'json',
			async:false,
			success:function(data){
				$('.likeCount, .dislikeCount').empty();
				$('.likeCount').append(data.like);
				$('.dislikeCount').append(data.dislike);
			}

		});
	}

});
