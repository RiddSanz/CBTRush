
<!-- saved from url=(0064)http://demos.9lessons.info/ajaxLoginServer/js/jquery.ui.shake.js -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252"></head><body><pre style="word-wrap: break-word; white-space: pre-wrap;">(function($) {
	$.fn.shake = function(o) {
		if (typeof o === 'function')
			o = {callback: o};
		// Set options
		var o = $.extend({
			direction: "left",
			distance: 20,
			times: 3,
			speed: 140,
			easing: "swing"
		}, o);

		return this.each(function() {

			// Create element
			var el = $(this), props = {
				position: el.css("position"),
				top: el.css("top"),
				bottom: el.css("bottom"),
				left: el.css("left"),
				right: el.css("right")
			};

			el.css("position", "relative");

			// Adjust
			var ref = (o.direction == "up" || o.direction == "down") ? "top" : "left";
			var motion = (o.direction == "up" || o.direction == "left") ? "pos" : "neg";

			// Animation
			var animation = {}, animation1 = {}, animation2 = {};
			animation[ref] = (motion == "pos" ? "-=" : "+=")  + o.distance;
			animation1[ref] = (motion == "pos" ? "+=" : "-=")  + o.distance * 2;
			animation2[ref] = (motion == "pos" ? "-=" : "+=")  + o.distance * 2;

			// Animate
			el.animate(animation, o.speed, o.easing);
			for (var i = 1; i &lt; o.times; i++) { // Shakes
				el.animate(animation1, o.speed, o.easing).animate(animation2, o.speed, o.easing);
			};
			el.animate(animation1, o.speed, o.easing).
			animate(animation, o.speed / 2, o.easing, function(){ // Last shake
				el.css(props); // Restore
				if(o.callback) o.callback.apply(this, arguments); // Callback
			});
		});
	};
})(jQuery);</pre></body></html>