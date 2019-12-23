(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		// DOM ready, take it away
        const instance = new Typewriter('#typewriter', {
            strings: [
                'IPA drinker extraordinaire', 
                'Guy with a patchy beard',
                'Lover of colorful socks',
                'Pancake aficionado',
            ],
            autoStart: true,
            loop: true,
        });
        
	});
	
})(jQuery, this);