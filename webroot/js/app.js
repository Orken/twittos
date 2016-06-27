  jQuery(document).ready(function($){
    // Stockage des références des différents éléments dans des variables
    rocket     = $('#rocket_mobile');
    firetop    = $('#rocket_mobile .fire.top');
    firebottom = $('#rocket_mobile .fire.bottom');
    LAST_SCROLL_OFFSET = $(window).scrollTop();
    LAST_SCROLL_TIME   = new Date().getTime();

    // Calcul de la marge entre le haut du document et #rocket_mobile
    fixedLimit = rocket.offset().top - parseFloat(rocket.css('marginTop').replace(/auto/,0));

    // On déclenche un événement scroll pour mettre à jour le positionnement au chargement de la page
    $(window).trigger('scroll');

    $(window).scroll(function(event){
      // Valeur de défilement lors du chargement de la page
      windowScroll = $(window).scrollTop();

      // Mise à jour du positionnement en fonction du scroll
      if( windowScroll >= fixedLimit ){
        rocket.addClass('fixed');
      } else {
        rocket.removeClass('fixed');
      }

      // Animation flammes
      // Allumage
      if( rocket.hasClass('fixed') ){
        if( windowScroll > LAST_SCROLL_OFFSET ){
          // DOWN
          firetop.addClass('on');
          firebottom.removeClass('on');
          LAST_SCROLL_DIRECTION = 'down';
        } else {
          // UP
          firetop.removeClass('on');
          firebottom.addClass('on');
          LAST_SCROLL_DIRECTION = 'up';
        }
      }

      // Arrêt
      setTimeout(function(){
        if( new Date().getTime() - LAST_SCROLL_TIME > 50 ){
          firetop.removeClass('on');
          firebottom.removeClass('on');

          // Animation inertie fusée
          if( rocket.hasClass('fixed') ){
            if( LAST_SCROLL_DIRECTION == 'down' ){
              rocket.animate({
                top: '+=5px'
              }, 50, function(){
                rocket.animate({
                  top: '-=5px'
                }, 120);
              });
            } else {
              rocket.animate({
                top: '-=5px'
              }, 50, function(){
                rocket.animate({
                  top: '+=5px'
                }, 120);
              });
            }
          }
        }
      },70);

      // Mise à jour variables
      LAST_SCROLL_OFFSET = windowScroll;
      LAST_SCROLL_TIME   = new Date().getTime();
    });
  });


  // Système spoiler
  $(function(){
        $('.spoiler-text').hide();
        $('.spoiler-toggle').click(function(){
            $(this).next().toggle();
        }); // end spoiler-toggle
  }); // end document ready
