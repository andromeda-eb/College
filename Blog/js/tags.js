$(document).ready(function(){ // type word then press comma to enter tag/ press backspace to delete tag
	[].forEach.call(document.getElementsByClassName('tags-input'), function(el){
		let hiddenInput = document.createElement('input'),
		mainInput = document.createElement('input');
		tags = [];

		hiddenInput.setAttribute('type', 'hidden');
		hiddenInput.setAttribute('name', el.getAttribute('data-name'));

		mainInput.setAttribute('type', 'text');
		mainInput.classList.add('main-input');

		mainInput.addEventListener('input', function(){
			let enteredTags = mainInput.value.split(','); // splits input tag by delimiter comma
			if(enteredTags.length > 1){
				enteredTags.forEach(function(t){
					let filteredTag = filterTag(t);
					if(filteredTag.length > 0) // add only if there is atleast one entered tag
						addTag(filteredTag);
				});

				mainInput.value = ''; // clear remaining text after comma is pressed / added to tag list
			}
		});

		mainInput.addEventListener('keydown', function(e){
			let keyCode = e.which || e.keyCode;
			if (keyCode === 8 && mainInput.value.length === 0 && tags.length > 0)
				removeTag(tags.length -1);
		});

		el.appendChild(mainInput);
		el.appendChild(hiddenInput);

		function addTag(text){
			let tag = {
				text: text,
				element: document.createElement('span'),
			};

			tag.element.classList.add('tag');
			tag.element.textContent = tag.text;

			let closeBtn = document.createElement('span');
			closeBtn.classList.add('close');
			closeBtn.addEventListener('click', function(){
				removeTag(tags.indexOf(tag));
			});

			tag.element.appendChild(closeBtn);

			tags.push(tag);

			el.insertBefore(tag.element, mainInput);

			refreshTags();
		}

		function removeTag(index){ // removes tag when x button is clicked
			let tag = tags[index];
			tags.splice(index, 1);
			el.removeChild(tag.element);
			refreshTags();
		}

		function refreshTags(){
			let tagsList = [];

			tags.forEach(function (t){
				tagsList.push(t.text);
			});

			hiddenInput.value = tagsList.join(',');
		}

		// for two or more word tags
		function filterTag(tag){
			 // replaces outside dashes and underscores with whitespace then trims. Replace inside whitespace with dashes
			return tag.replace(/[^\w -]/g, '').trim().replace(/\W+/g, '-');
		}
	});
});