/*
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
| Global Variables
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
var placeholders = '',
	textRight = document.getElementById('word'),
	win = false,
	right = 0,
	wrong = 0,
	abc = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'],
	letters = document.getElementById('letters'),

	// Масив с всички думи
	words = ['legendary', 'variation', 'equal', 'approximately', 'segment', 'priority', 'physics', 'branche', 'science', 'mathematics', 'lightning', 'dispersion', 'accelerator', 'detector', 'terminology', 'design', 'operation', 'foundation', 'application', 'chair', 'computer', 'laptop', 'television', 'salad', 'desk', 'bicycle', 'suitcase', 'backpack', 'wood', 'curtain'],
	
	// На случаен принцип избира дума от масива
	word = words[Math.floor(Math.random()*words.length)];
	console.log (word);


/*
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
| Определя дължината на думата и изписва толкова чертички
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
for (i = 0; i < word.length; i++) {	
	placeholders += '_';
}
textRight.innerHTML = placeholders;


/*
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
| Изписва клавиатурата
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
for (var i = 0; i < abc.length; i++) {
	var div = document.createElement('div');
		div.style.cursor = 'pointer';
		div.innerHTML = abc[i];
		div.onclick = remLetter;
		div.onmouseover = hover;
		div.onmouseout = unHover;
		letters.appendChild(div);
}

function hover() {
	this.style.background = '#006';
	this.style.color = 'white';
}

function unHover() {
	this.style.background = '#ed4d01';
	this.style.color = 'black';
}

/*
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
| Премахва кликната буква
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
function remLetter() {
	inputValue = this.innerHTML;
	checkLetter();
	this.innerHTML = '&nbsp;';
	this.style.cursor = 'default';
	this.onclick = null;
	this.onmouseover = null;
}

/*
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
| Рисува бесилото и изписва сгрешените букви на екрана
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
function draw() {
	var x;		
	for (var i = 1; i <= 8; i++) {
		switch(wrong) {
			case i:
				x = '<img src="apps/hangman-en/img/' + i + '.png">';
		}
	}
	
	if (wrong < 9) {
		document.getElementById('hang').innerHTML = x;
		document.getElementById('textWrong').innerHTML += inputValue;
	}	
}

/*
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
| Проверява дали в думата има кликнатата буква
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
function checkLetter () {
	
	var underscore = document.getElementById('word').innerHTML,
		wrongGuess = true;
	
	underscore = underscore.split('');
	for (i = 0; i < word.length; i++) {
		if (word.charAt(i) == inputValue.toLowerCase()) {
			
	        underscore[i] = inputValue.toUpperCase();      
	        right++;
	        wrongGuess = false;

	        // Следи за броя на верните отговори и ако той е равен на дължината на думата уведомява играча че е спечелил
	        if (right == word.length) {
	        	win = true;
			}	
     	}
	}

	if (wrongGuess) {
		wrong++;

		// Следи за броя на грешните отговори и ако той е равен на 9 генерира нов екран който уведомява играча че е загубил и изписва думата
		if (wrong == 9) {
			document.getElementById('wrap').innerHTML = '<p class="over"> Game Over </p><p class="overWord">The word is:  ' + word.toUpperCase() + '</p><br><input type="submit" value="Reset" id="reset" class="button" onclick="location.reload()">';
		}

		draw();
	}

	// Ако кликнатата буква е била правилна обновява изписаната на екрана дума
	if (!wrongGuess) {
		textRight.innerHTML = underscore.join('');
	}
	if (win) {
		alert('You win. The answer is:  ' + word.toUpperCase());
		window.location.reload();
	}
}	
