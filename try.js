var client_id = 'HIDE';
var client_secret = 'HIDE';
var redirect_uri = 'http://accio.bearbricklab.com/callback.html';

function login() {
  var url = 'https://accounts.spotify.com/authorize?client_id=' + client_id +
	'&response_type=token&' +
	'&scope=playlist-read-private%20playlist-modify%20playlist-modify-private%20user-read-private' +
	'&redirect_uri=' + encodeURIComponent(redirect_uri);
  var w = window.open(url, 'Login Window', 'WIDTH=400,HEIGHT=650');
  
}