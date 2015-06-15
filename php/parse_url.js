	function parseURL(url) {
		var url_re, url_matches, url_parts, authority, credentials;

		url_re = /((\w+):)?(\/\/([^\/]*))?(\/.*)?/i;
		url_matches = url_re.exec(url);

		url_parts = {
			'scheme' : url_matches[1] !== undefined ? url_matches[2] : null,
			'path' : url_matches[5] !== undefined ? url_matches[5] : null
		};

		if (url_matches[3] === undefined) {
			// no server information

		} else if (url_matches[4].indexOf('@') === -1) {
			url_parts.host = url_matches[4];
		} else {
			authority = url_matches[4].split('@', 2);
			url_parts.host = authority[1];

			if (authority[0].indexOf(':') === -1) {
				url_parts.user = authority[0];
			} else {
				credentials = authority[0].split(':');
				url_parts.user = credentials[0];
				url_parts.pass = credentials[1];
			}
		}

		return url_parts;

	}
