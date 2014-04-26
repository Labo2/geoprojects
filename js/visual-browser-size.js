// Visual Browser Size @ http://xycss.com/xy/tools/visual-browser-size/

function xycss_dynamic_browser_size(){
	jQuery('#browser-size').text('w : ' + jQuery(window).width() + ' , h : ' + jQuery(window).height()).css({
		width:'140px', bottom:'0', left:'0', background:'#000', cursor:'pointer', padding:'0.75em', 
		zIndex:9999, position:'fixed', textDecoration:'none', color:'#fff', opacity:0.8, fontSize: '12px'
	}).hover(function(){
		jQuery(this).css({ opacity:0.7 });
	},function(){
		jQuery(this).css({ opacity:0.3 });
	});
}
jQuery(document).ready(function(){
	jQuery('body').append('<div class="button" id="browser-size"></div>');
	xycss_dynamic_browser_size();
});
jQuery(window).resize(function() {
	xycss_dynamic_browser_size();
});