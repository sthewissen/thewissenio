(function ($, root, undefined) {
	
	$(function () {
		
        'use strict';
        
        var items = [
            'IPA drinker extraordinaire', 
            'Guy with a patchy beard',
            'Lover of colorful socks',
            'Pancake aficionado',
            'Proud Microsoft MVP',
            'Xamarin developer',
            'Sucker for stickers',
            'Photoshop tinkerer',
            'Bloke that wrote a book',
            'Xbox & Switch gamer',
            'Music lyrics sponge',
            'Five a side player',
            'Rock concert goer',
            'Aspiring guitarist'
        ];
		
		// DOM ready, take it away
        const instance = new Typewriter('#typewriter', {
            strings: shuffle(items),
            autoStart: true,
            loop: true,
        });
        
    });
    
    function shuffle(a) {
        var j, x, i;
        for (i = a.length - 1; i > 0; i--) {
            j = Math.floor(Math.random() * (i + 1));
            x = a[i];
            a[i] = a[j];
            a[j] = x;
        }
        return a;
    }
	
})(jQuery, this);