// Get all the elements
var currentIndex = null;

var framesLeft;
var framesViewed;

var infoText;
var questionsText;

Init();

window.onhashchange = CheckHashChange()

function CheckHashChange()
{
	console.log("hash has been changed. It's currently " + location.hash);
	// Looks like the hash has changed, go ahead and see if it's a frame.
	// If so download the frame's data and display it.
	
	// Remove the # from the hash.
	var index = location.hash.substr(1);

	// Verify it's actually a number above zero.
	if(+index > 0)
	{
		// Make sure the info page is closed first.
		ShowInfo(false);

		console.log("hash changed, new index is " + index);
		// Show that frame.
		ShowFrame(index);
	}
}

function ShowInfo(value)
{
	// Depending on the value show or hide a div
	if(value)
	{
		infoText.removeAttribute("hidden");
		questionsText.setAttribute("hidden","yes");
	}
	else
	{	
		infoText.setAttribute("hidden","yes");
		questionsText.removeAttribute("hidden");
	}
}

function Init()
{
	// Download or get the frames.
	InitFrames();

	// Info and question boxes.
	infoText = document.getElementById("info");
	questionsText = document.getElementById("questions");
	ShowInfo(true);

	// Make the start button do something.
	var startButton = document.getElementById("startButton");
	startButton.onclick = function()
	{
		// Show the 'next' frame
		ShowInfo(false);
		NextFrame();
	};

	// Make the start buttons actually do something.
	// BUG: Pressing the emoji does not send event in chrome.
	var questions = document.getElementById("questions");
	questions.onclick = function(e)
	{
		var vote = e.target.dataset.vote;

		if(vote != null)
		{
			NextFrame();
		}
	}
}

function InitFrames()
{
	if(framesLeft == null)
	{
		framesLeft = JSON.parse(localStorage.getItem('framesRemaining'));

		if(!framesLeft)
		{
			// Download the list of frames from the sever.
			fetch("public/api.php/get/frame")
			.then(function(response)
			{
				return response.json();
			})
			.then(function(data)
			{
				data = CheckJson(data);
				data = shuffle(data);

				if(data != null)
				{
					framesLeft = data;
					localStorage.setItem('framesRemaining', JSON.stringify(framesLeft));
					// localStorage.setItem('framesComplete', framesViewed);
					console.log('Saved all frames to localStorage');
				}
			});
		}
		else
		{
			framesViewed = localStorage.getItem('framesRemaining');
			console.log('Loaded frames remaining from localStorage');
		}
	}
}
function NextFrame()
{
	// Before the current frame is set, send the vote.
	
	// Pop the next frame into current frame.
	currentIndex = framesLeft.pop();
	localStorage.setItem('framesRemaining', JSON.stringify(framesLeft));
	location.hash = currentIndex;
	// FF and Chrome did not automaticly update
	console.log("changed hash");
}

function SetFrame(frameData)
{
	var picture = document.querySelector("#frame");
	picture.children[0].srcset = frameData['images']['low'];
	picture.children[1].srcset = frameData['images']['full'];
	picture.querySelector("img").src = frameData['images']['full'];

	document.getElementById('source').innerHTML = frameData['source'] + " - " + frameData['time'];


	var indexString = "id:" + frameData['id'];
	indexString += ", total:" + frameData['votes']['total'];
	indexString += ", yes:" + frameData['votes']['yes'];
	indexString += ", no:" + frameData['votes']['no'];
	indexString += ", not sure:" + frameData['votes']['not sure'];

	document.getElementById('index').innerHTML = "[ "+indexString+" ]";

	location.hash = frameData['id'];
}

function ShowFrame(index)
{
	var picture = document.querySelector("#frame");
	picture.children[0].srcset = "";
	picture.children[1].srcset = "";
	picture.querySelector("img").src = "";

	document.getElementById('source').innerHTML = "";

	// Download the frame data from the server.
	fetch("public/api.php/get/frame/" + index)
	.then(function(response)
	{
		return response.json();
	})
	.then(function(data)
	{
		data = CheckJson(data);
		SetFrame(data);
	});	
}

function ChangeFrame()
{
	localStorage.setItem('framesRemaining', framesLeft);
	localStorage.setItem('framesComplete', framesViewed);
}

function SetHero(frame)
{

}

function CheckJson(json)
{
	if(json.hasOwnProperty("error"))
	{
		console.log(`API returned an ${json['type']}. ${json['details']['message']} In file ${json['details']['file']} [${json['details']['line']}]`);
		return null;
	}
	return json;
}

function shuffle(array)
{
	var j, x, i;
	for (i = array.length - 1; i > 0; i--)
	{
		j = Math.floor(Math.random() * (i + 1));
		x = array[i];
		array[i] = array[j];
		array[j] = x;
	}
	return array;
}