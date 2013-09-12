var mines = [],
	stage = document.getElementById('stage'),
	time = 0,
    elapsed = '0',
	timerDiv = document.getElementById('timer'),
	timerValue = 0,
	user = username,
	scoreArr;
for (var i = 0; i < 81; i++) {
	var div = document.createElement('div');
		div.className = 'box';
		div.id = i;
		div.onclick = clk;
		div.oncontextmenu = rightClick;
		div.innerHTML = '&#32;';
		stage.appendChild(div);
}
function natSort(as, bs){
    var a, b, a1, b1, i= 0, L, rx=  /(\d+)|(\D+)/g, rd=  /\d/;
    if(isFinite(as) && isFinite(bs)) return as - bs;
    a= String(as).toLowerCase();
    b= String(bs).toLowerCase();
    if(a=== b) return 0;
    if(!(rd.test(a) && rd.test(b))) return a> b? 1: -1;
    a= a.match(rx);
    b= b.match(rx);
    L= a.length> b.length? b.length: a.length;
    while(i < L){
        a1= a[i];
        b1= b[i++];
        if(a1!== b1){
            if(isFinite(a1) && isFinite(b1)){
                if(a1.charAt(0) === "0") a1= "." + a1;
                if(b1.charAt(0) === "0") b1= "." + b1;
                return a1 - b1;
            }
            else return a1> b1? 1: -1;
        }
    }
    return a.length - b.length;
}

function compareNumbers(a, b) {
  return a - b;
}
function rightClick() {
	if (this.className == 'box flag' || this.className == 'box mine flag') {
		var ind = this.className.indexOf('flag');
		if (ind === 4) {
			this.className = 'box';
		} else {
			this.className = 'box mine';
		}
		this.onclick = clk;
	} else {
		this.className = this.className + ' flag';
		this.onclick = 'none';		
	}
}

function positionMines() {
	for (var i = 0; i < 10; i++) {
		mines[i] = Math.round(Math.random()*80);
	}
	
	var results = [],
		sorted_arr = mines.sort();
		
	for (var i = 0; i < mines.length; i++) {
		if (sorted_arr[i + 1] != sorted_arr[i]) {
			results.push(sorted_arr[i]);
		}
	}
	
	if (results.length != 10) {
			positionMines();
		} else {
			for (var i = 0; i < 10; i++) {	
				if (document.getElementById(mines[i]).className == 'box') {
					document.getElementById(mines[i]).className = document.getElementById(mines[i]).className + ' mine';
				}
			}			
		}
}

positionMines();


function clk() {

	timer();	
	el = this;
	check(el);
	win();
}

function check(el) {
	var id = parseInt(el.id),
		j = 0,
		matrixOne = [],
		clickedClass = document.getElementsByClassName('box clicked'),
		clicked = [];
	
	if (el.className == 'box mine') {
		boom();
		
	} else {
		sw(matrixOne, id);
		
		el.style.background = '#111';
		el.onclick = 'none';
		el.style.cursor = 'default';
		el.className = el.className + ' clicked';
		el.id = 'clicked';
		
		for (var i = 0; i < matrixOne.length; i++) {
			if (document.getElementById(matrixOne[i]) ) {
				if (document.getElementById(matrixOne[i]).className === 'box mine' || document.getElementById(matrixOne[i]).className === 'box mine flag') {
					j++;
				}		
				
			}
			
		}
		
		for (var i = 0; i < matrixOne.length; i++) {
			if (document.getElementById(matrixOne[i]) ) {	
				
				if (j != 0) {
					el.innerHTML = j;
				} else {
					el.innerHTML = '&#32;';
					check(document.getElementById(matrixOne[i]));	
				}
			}
		}
		
	  }
}

function sw(matrix, id) {
	switch (id) {
			case 0:
				matrix.push(id + 1, id + 9, id + 10);
				break;
			case 1: case 2: case 3: case 4: case 5: case 6: case 7: 
				matrix.push(id - 1, id + 1, id + 8, id + 9, id + 10);
				break;
			case 8:
				matrix.push(id - 1, id + 8, id + 9);
				break;	
			case 9: case 18: case 27: case 36: case 45: case 54: case 63:
				matrix.push(id - 9, id - 8, id + 1, id + 9, id + 10);
				break;
			case 72:
				matrix.push(id - 9, id - 8, id + 1);
				break;
			case 73: case 74: case 75: case 76: case 77: case 78: case 79: 
				matrix.push(id - 10, id - 9, id - 8, id - 1, id + 1);
				break;
			case 80:
				matrix.push(id - 10, id - 9, id - 1);
				break;
			case 17: case 26: case 35: case 44: case 53: case 62: case 71:
				matrix.push(id - 10, id - 9, id - 1, id + 8, id + 9);
				break;
			default:	
				matrix.push(id - 10, id - 9, id - 8, id - 1, id + 1, id + 8, id + 9, id + 10);
				break;
		}	
}


function boom() {
	var m = document.getElementsByClassName('box mine');
	
	var boxes = document.getElementsByClassName('box');
	for (var i = 0; i < boxes.length; i++) {
		document.getElementById(boxes[i].id).onclick = 'none';
		document.getElementById(boxes[i].id).style.cursor = 'default';
	}
	for (var i = 0; i < m.length; i++) {
		document.getElementById(m[i].id).id = 'boom';
	}
	alert('BOOOOOM!!!');
	timerValue = timerDiv.innerHTML;
	if (timerValue != 0) {
		document.getElementById('timerWrap').innerHTML = timerValue;
	} else {
		document.getElementById('timerWrap').innerHTML = '';
	}
	res('Lose');
	changeHeading('You Lose!', '#930b0b');
}

function win() {
	var n = document.getElementsByClassName('box clicked'),
		m = document.getElementsByClassName('box mine');
	if (n.length == 81 - m.length) {
		timerValue = timerDiv.innerHTML;
		document.getElementById('timerWrap').innerHTML = timerValue;
		for (var i = 0; i < m.length; i++) {
			document.getElementById(m[i].id).onclick = 'none';
			document.getElementById(m[i].id).id = 'boom';
			document.getElementById(m[i].id).style.cursor = 'none';
		}
		res('Win');
		changeHeading('You Win!', 'green');
		$.post('index.php', {'ajax':1, 'parser':'games', 'player':user, 'score':timerValue, 'game':'minesweeper', 'score_order':'asc'});
	}
}

function timer() {
	if (timerDiv.innerHTML === '') {
		window.setInterval(function() {
			time += 100;
			elapsed = Math.floor(time / 100) / 10;
			if(Math.round(elapsed) == elapsed) { elapsed += '.0'; }
			timerDiv.innerHTML = elapsed;
		}, 100);
	}
	
}

function res(value) {	
	document.getElementById('res').id = 'res' + value;
}

function changeHeading(val, color) {
	document.getElementById('heading').innerHTML = val;
	document.getElementById('heading').style.color = color;
	document.getElementById('heading').style.textShadow = 'none';
}

function capitaliseFirstLetter(string) {
   	return string.charAt(0).toUpperCase() + string.slice(1);
}

function showScore() {
	document.getElementById('mask').style.display = 'block';
}
function hideScore() {
	document.getElementById('mask').style.display = 'none';
}

function showMines() {
	$(".mine").css('background', 'red');
}
function hideMines() {
	$(".mine").css('background', '#555');
}