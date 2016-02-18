(function(exports) {

	var client_id = 'HIDE';
	var client_secret = 'HIDE';
	var redirect_uri = 'http://www.bearbricklab.com/playlist/new';

	var doLogin = function(callback) {
		var url = 'https://accounts.spotify.com/authorize?client_id=' + client_id +
			'&response_type=code' +
			'&scope=user-read-private' +
			'&redirect_uri=' + encodeURIComponent(redirect_uri);
		var w = window.open(url, 'asdf', 'WIDTH=400,HEIGHT=500');
	}

	exports.startApp = function() {
		setStatus('');
		$('#start').click(function() {
			doLogin(function() {});
		})
	}

})(window);