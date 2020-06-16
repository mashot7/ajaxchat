let lastTimeID = 0;

$(document).ready(function() {
	$('#btnSend').click(function(){
		sendChatText();
		$('#chatInput').val("");
	});
	startChat();
});

function startChat(){
	setInterval(function(){ getChatText(); }, 2000);
}

function getChatText(){
	$.ajax({
		type: "GET",
		url: "/refresh.php?lastTimeID="+lastTimeID
	}).done(function( data )
	{
		let jsonData = JSON.parse(data);
		let jsonLength = jsonData.results.length;
		let html = "";
		for (let i = 0; i < jsonLength; i++) {
			let result = jsonData.results[i];
			html += `<div style="#${result.color}">(${result.chattime}) <b> ${result.usrname} </b>: ${result.chattext}</div>`;
			lastTimeID = result.id;
		}
		$('#view_ajax').append(html);
	});
}

function sendChatText(){
	let chatInput = $('#chatInput').val();
	if(chatInput != ""){
		$.ajax({
			type: "GET",
			url: "/submit.php?chattext=" + encodeURIComponent( chatInput )
		});
	}
}