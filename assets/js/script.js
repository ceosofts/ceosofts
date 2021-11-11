$(function(){

	$("body").on("click", ".btn-add", function(e){
		e.preventDefault();
		let ol = $(this).closest("ol")
		let li = $(this).closest("li").clone()
		li.appendTo(ol)
		li.find("input").val("")
		li.find(".btn-remove").show()
		li.find("[name='cOrder[]']").focus()
	})

	$("body").on("click", ".btn-remove", function(e){
		e.preventDefault()
		$(this).closest("li").remove()
	})

})