// Get all the elements
var currentFrame = null;

var framesLeft;
var framesViewed;

window.onload = function()
{
	Init();
}

function Init()
{
	var startButton = document.getElementById("startButton");
	startButton.onclick = function()
	{
		Start();
		NextFrame();
	};

	var questions = document.getElementById("questions");
	questions.onclick = function(e)
	{
		var vote = e.target.dataset.vote;

		if(vote != null)
		{
			NextFrame();
		}
	}


	if(framesLeft == null)
	{
		framesLeft = JSON.parse(localStorage.getItem('framesRemaining'));

		if(!framesLeft)
		{
			// Download the list of frames from the sever.
			fetch("https://tomp.id.au/pages/minions/public/api.php/get/frame")
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
function Start()
{
	var questions = document.querySelector("#questions");
	questions.removeAttribute("hidden");

	var info = document.querySelector("#info");
	info.setAttribute("hidden","yes");
}

function NextFrame()
{
	localStorage.setItem('framesRemaining', JSON.stringify(framesLeft));
	// Before the current frame is set, send the vote.
	
	// Pop the next frame into current frame.
	currentFrame = framesLeft.pop();
	ShowFrame(currentFrame);

	
}

function SetFrame(frameData)
{
	var picture = document.querySelector("#frame");
	picture.children[0].srcset = frameData['images']['low'];
	picture.children[1].srcset = frameData['images']['full'];
	picture.querySelector("img").src = frameData['images']['full'];

	document.getElementById('source').innerHTML = frameData['source'] + " - " + frameData['time'];
}

function ShowFrame(index)
{
	var picture = document.querySelector("#frame");
	picture.children[0].srcset = "";
	picture.children[1].srcset = "";
	picture.querySelector("img").src = "";

	document.getElementById('source').innerHTML = "";

	// Download the frame data from the server.
	fetch("https://tomp.id.au/pages/minions/public/api.php/get/frame/" + index)
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