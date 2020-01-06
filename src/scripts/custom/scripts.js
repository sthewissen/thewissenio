(function ($, root, undefined) {
	
	$(function () {
		
        'use strict';
        
		
        // DOM ready, take it away
        var typer = document.getElementById("typewriter");

        if(typer != null)
        {
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

            const instance = new Typewriter('#typewriter', {
                strings: shuffle(items),
                autoStart: true,
                loop: true,
            });
        }

        var logo = document.getElementById("logo");

        if(logo != null){
            TweenMax.set("#logo",{opacity:1});

            $("#logo").hover(
              
              function(){
                var logo_in = new TimelineMax({})
            
                .to("#logo #buttonMax", 0.4, {rotation:-90, scale:0.8, y:-4, transformOrigin:"0% 50%", ease: Power0.easeNone}, "s")
                .to("#logo #topMini, #topMax", 0.6, {y:20, ease: Power0.easeNone}, "s")
                .to("#logo #topMini", 0.5, {x:20, scale:0.8,  ease: Power0.easeNone}, "s")
                .to("#logo #butoonMini", 0.7, {rotation:-90, y:-4, x:3.9, scale:0.8, transformOrigin:"0% 0%", ease: Power0.easeNone}, "s");
                logo_in.duration(0.4);
              },
              
              function(){
                var logo_out = new TimelineMax({})
            
                .to("#logo #buttonMax", 0.4, {rotation:0, scale:1,  y:0, transformOrigin:"0% 50%", ease: Power0.easeNone}, "s")
                .to("#logo #topMini, #topMax", 0.6, {y:0, ease: Power0.easeNone}, "s")
                .to("#logo #topMini", 0.5, {x:0, scale:1, ease: Power0.easeNone}, "s")
                .to("#logo #butoonMini", 0.7, {rotation:0, y:0, x:0, scale:1, transformOrigin:"0% 0%", ease: Power0.easeNone}, "s");
                logo_out.duration(0.3);                
              }             
            );
        }
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