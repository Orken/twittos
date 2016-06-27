tinymce.init({
	// General options
	selector: '#wysiwyg',
	skin: 	'myskin',
	plugins: 	'image link emoticons codesample media textcolor spoiler',
	content_css : "../../webroot/css/custom_content.css",
	height: 600,
	//theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
	//font_size_style_values : "10px,12px,13px,14px,16px,18px,20px",

	// Menu et toolbar
	toolbar: 	'undo redo | forecolor fontsizeselect styleselect bold italic | alignleft aligncenter alignright alignjustify | spoiler-add spoiler-remove | codesample link | space | space | image media emoticons',
	menubar: 	false, 

	// Specifications / Restrictions
	media_alt_source: false,
	media_poster: false,
	media_dimensions: false,
	image_description: false,
	image_dimensions: false,
	fontsize_formats: '10pt 12pt 14pt 18pt 24pt 36pt',
});


function verif_contenu_wysiwyg()
{
	// Permet de recuperer le contenu sans les balises
	var value = tinymce.activeEditor.getContent({format : 'text'})

	if (value.length < 3)
	{ 
		alert("Vous ne pouvez pas laisser le contenu vide.");
		return false;
	}
	else if (value.length > 800) {
		alert("Contenu trop long. 800 caractères maximum.");
		return false;
	}

	return
}


function refuserToucheEntree(event)
{
	// Compatibilité IE / Firefox
	if(!event && window.event) {
	event = window.event;
	}
	// IE
	if(event.keyCode == 13) {
	event.returnValue = false;
	event.cancelBubble = true;
	}
	// DOM
	if(event.which == 13) {
	event.preventDefault();
	event.stopPropagation();
	}
}



// formulaire de recherche JQuery
$(document).ready( function() {
  // détection de la saisie dans le champ de recherche
  $('#q').keyup( function(){
    $field = $(this);
    $('#results').html(''); // on vide les resultats
    $('#ajax-loader').remove(); // on retire le loader
 
    // on commence à traiter à partir du 2ème caractère saisie
    if( $field.val().length > 2 )
    {
      // on envoie la valeur recherché en GET au fichier de traitement
      $.ajax({
  	type : 'GET', // envoi des données en GET ou POST
	url : 'actionSearch' , // url du fichier de traitement
	data : 'q='+$(this).val() , // données à envoyer en  GET ou POST
	beforeSend : function() { // traitements JS à faire AVANT l'envoi
		$field.after('<img src="/Twittos1/js/ajax-loader.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
	},
	success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
		$('#ajax-loader').remove(); // on enleve le loader
		$('#results').html(data); // affichage des résultats dans le bloc
	}
      });
    }		
  });
});