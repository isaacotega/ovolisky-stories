$(document).ready(function() {

	var navIsOut = false;

	$("#navIcon").click(function() {

		if(navIsOut == false) {

			$(this).css("color", "purple");

			$("#sideNav").css("width", "15cm");
		
			navIsOut = true;

		}

		else {

			$(this).css("color", "white");

			$("#sideNav").css("width", "0%");

			navIsOut = false;

		}
	
	});

	var chapterNavIsOut = false;

	$("#chapterNavIcon").click(function() {

		if(chapterNavIsOut == false) {

			$(this).css("color", "purple");

			$("#chapterNav").css("width", "15cm");
		
			chapterNavIsOut = true;

		}

		else {

			$(this).css("color", "white");

			$("#chapterNav").css("width", "0%");

			chapterNavIsOut = false;

		}
		
	});
	
	$("[category=accountSideLinks]").css({
		borderLeft: "5px solid indigo",
		textIndent: "2cm"
	}).hide();
	
	var accountMenuIsOut = false;

	$("#slkAccount").click(function() {
	
		if(accountMenuIsOut) {
		
			$("[category=accountSideLinks]").hide();
			
			accountMenuIsOut = false;

		}
		
		else {
	
			$("[category=accountSideLinks]").show();
			
			accountMenuIsOut = true;

		}
	
	});
	
	for(var i = 0; i < $("[class=lengthIndicator]").length; i++) {
	
		$("[id=" + $("[class=lengthIndicator]").eq(i).attr("for") + "]").keyup(function() {
	
			var lengthIndicator = $('label[for=' + $(this).attr("id") + ']');
	
			$(lengthIndicator).html( $(this).val().length + " <em> (" + $(lengthIndicator).attr("minimum") + " - " + $(lengthIndicator).attr("maximum") + ") </em>" );
		
		});

	}
	
	var cookieAlert = $('<div id="cookieAlert"> <div id="statementHolder"> <p>This website uses cookies to provide our services, for advertising and analytics, personalize content and give you the best experience possible.</p> <p>By using our website, we assume you are okay with it.</p> </div> <div id="buttonHolder"> <button id="btnOk">Ok</button> </div> </div>');
	
	setTimeout(function() {
		
		if(sessionStorage.getItem("cookieAccepted") !== "true") {
	
			$("#main").append(cookieAlert);
			
			$("#btnOk").click(function() {
			
				$("#cookieAlert").fadeOut(500, function() {
					
					sessionStorage.setItem("cookieAccepted", "true");
				
					$("#cookieAlert").remove();
				
				});
			
			});
	
		}
	
	}, 1000);
	
});

function placeholder(element, message) {
	
	message = message !== undefined ? message.replace(/@loader/g, '<div id="loader"></div>') : '<div id="loader"></div> Loading . . .';
	
	$(element).html('<div id="placeholder"> <div id="message">' + message + '</div> </div>');
	
}
	