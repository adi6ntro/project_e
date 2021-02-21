$(document).ready(function () {
	var school = $(window);
	var page = $('html, body');

	$(window).scroll(function () {
		if ($(window).scrollTop() >= 100) {
			$('#header_top').addClass('animate__animated animate__slideInDown fix');
		}
		else {
			$('#header_top').removeClass('animate__animated animate__slideInDown fix');
		}
	});
	$(".logoarea").click(function () {
		document.getElementById('myDropdown').classList.toggle("show");
	});
	$(window).click(function (e) {
		if (!(e.target.matches('.logoarea') || e.target.matches('.dropdown') || e.target.matches('.logoarea > img'))) {
			var myDropdown = document.getElementById("myDropdown");
			if (myDropdown.classList.contains('show')) {
				myDropdown.classList.remove('show');
			}
		}
	});
});
