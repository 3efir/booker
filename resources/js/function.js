$(document).ready(function() {
	$('body').on('click', '.close', function() {
		return confirm("Are you sure you want delete this Empoyee ?");
	});
	$('input[type="radio"]').click(function() {
		if($(this).attr("value")=="yes") {
			$("#yes").show();
		}
		if($(this).attr("value")=="no") {
			$("#yes").hide();
		}
	})
})
function newMyWindow(e) {
  var h = 500,
      w = 500;
  window.open(e, '', 'scrollbars=1,height='+Math.min(h, screen.availHeight)+
  ',width='+Math.min(w, screen.availWidth)+',left='
  +Math.max(0, (screen.availWidth - w)/2)+',top='
  +Math.max(0, (screen.availHeight - h)/2));
}
$(function() {
   $("#delete").click(function(){
      if (confirm("Are you sure you want delete this event?")){
         $('form#editForm').submit();
      }
   });
});