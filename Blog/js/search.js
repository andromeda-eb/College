$(document).ready(function(){

	$('.filter1').change(function(){ // on change of first filter select tag

		$('.filterInput1Container').empty();

		var filterArray = ['username', 'date', 'tags', 'keyword'];

		filterInputAppend('1', $(this).val());

		$('.filter2').empty(); // empty filter 2
		$('.filter2').append('<option selected="selected">Choose Filter</option>');

		$('.filterInput2Container').empty();
		for( i in filterArray )
			if( $(this).val() !== filterArray[i] ) // and print out all the value of filterArray that isn't equals to filter 1
				$('.filter2').append('<option value="' + filterArray[i] + '" name = "' + filterArray[i] + '">' + filterArray[i] +  ' </option>');
	});

	$('.filter2').change(function(){ 
		$('.filterInput2Container').empty();
		filterInputAppend('2', $(this).val());
	});

	function filterInputAppend(filterNumber, input){ // appends the desired input type tage into the appropriate container

		if(input == 'date')
			$('.filterInput' + filterNumber +'Container').append(
				fillInputTag(filterNumber, 'Start Date', 'start' + 'filter' + filterNumber, 'start' + input) + 
				fillInputTag(filterNumber, 'End Date', 'end' + 'filter' + filterNumber, 'end' + input)
			);
		else
			$('.filterInput' + filterNumber +'Container').append(fillInputTag(filterNumber, input, 'filter' + filterNumber, input));
	}

	function fillInputTag(filterNumber, inputLabel, className, name){ // function for filling out an input tag for search

		var filterInputTag = `<span class = "filter` + filterNumber + `Label">` 
						   + inputLabel + ` &nbsp; <input type  = "text"` + `class ="` 
						   + className +`InputTag" name = ` + name + `> </span>`;

		return filterInputTag;

	}

	$('.filterSearchButton').on('click', function(){
			// if filter drop downs haven't been selected
			if($('.filter1').val() == 'Choose Filter' || $('.filter2').val() == 'Choose Filter')
				$('.searchError').text('Atleast two filters must be applied before searching').css('color', '#FF0033');
			// if the first filter inputs have not been defined
			else if( $('.filter1').val() !== 'date' && $('.filter1InputTag').val() == '' )
				$('.searchError').text('First filter must be defined').css('color', '#FF0033');
			// if the first filter is date and start date and end date have not been defined
			else if( $('.filter1').val() == 'date' &&  ( $('.startfilter1InputTag').val() == '' || $('.endfilter1InputTag').val() == '' ))
				$('.searchError').text('start and end date must be defined').css('color', '#FF0033');
			// if the second filter input tag has not been defined
			else if( $('.filter2').val() !== 'date' && $('.filter2InputTag').val() == '' )
				$('.searchError').text('Second filter must be defined').css('color', '#FF0033');
			// if the second filter is date and start and end date have not been defined
			else if( $('.filter2').val() == 'date' &&  ( $('.startfilter2InputTag').val() == '' || $('.endfilter2InputTag').val() == '' ))
				$('.searchError').text('start and end date must be defined').css('color', '#FF0033');
			else{
				$('.searchError').text('Search Success').css('color', '#4BB543');
				searchFunction();
			}
	});

	function searchFunction(){

		$.ajax({

	        url:"../php/search.php",
	        data: $('.searchForm').serialize(),
	        dataType:'text',
	        method:'POST',
	        success:function(data){

	        	$('.searchResults').empty();
	        	$('.searchResults').append(data);
	        	animateSearchBox();

        	}
   		});

	}

	function animateSearchBox(){
		$('.indexBox').animate({"margin-left": '0%'},880)
	}

	 $('.searchContainer').animate({"margin-right": '16%'},880); // animates the create blog box

});
