function show_mess(lng, val) {
	return MSG[lng][val];
}
var fullsidebar = 0;
function toggle_sidebar() {
	if (fullsidebar == 0) {
		$("#sidebar").animate({left: 0}, 300, function() {
			$("#depts").css("left", 200);
			$("#content").css("margin-left", 465);
			$("#arrow").attr("data", "images/arrow1.svg");
			fullsidebar = 1;
		});
	}
	else {
		$("#sidebar").animate({left: -120}, 300, function() {
			$("#depts").css("left", 80);
			$("#arrow").attr("data", "images/arrow.svg");
			$("#content").css("margin-left", 345);
			fullsidebar = 0;
		});
	}
}
function chmodule(did, mid) {
  $.ajax({
    type: "POST",
    url: "xp_main_funcs.php",
    timeout: 5000,
    data: "section=6&did=" + did + "&mid=" + mid,
    success: function(data) {
    },
    error: function(data) {
    	$("#errtd").html("Module link error!");
    }
  });
}
function dept_add(id, ttl) {
  $.ajax({
    type: "POST",
    url: "xp_main_funcs.php",
    timeout: 5000,
    data: "section=1&dept_id=" + id + "&ttl=" + ttl,
    success: function(data) {
    	//alert(data);
    	if (data == "0")
	    	$("#errtd").html("Dept exists!");
	    else
	    	{
  			$("#lastest").before(data);
			$("#table_main_page").tableDnD();
			$("#table_main_page").Sort("xp_main_funcs.php", 3);
			$("#dept_name").val("");
  		}
    },
    error: function(data) {
    	$("#errtd").html("Dept add error!");
    }
  });
}
function dept_del(id, did) {
  $.ajax({
    type: "POST",
    url: "xp_main_funcs.php",
    timeout: 5000,
    data: "section=2&dept_id=" + id + "&did=" + did,
    success: function(data) {
    	//alert(data);
			$("#line" + did).remove();
    },
    error: function(data) {
    	$("#errtd").html("Dept del error!");
    }
  });
}
function dept_inc(id, inc) {
  $.ajax({
    type: "POST",
    url: "xp_main_funcs.php",
    timeout: 5000,
    data: "section=3&id=" + id + "&inc=" + inc,
    success: function(data) {
    	//alert(data);
    },
    error: function(data) {
    	$("#errtd").html("Dept include error!");
    }
  });
}
function dtype_add(dtype) {
  $.ajax({
    type: "POST",
    url: "xp_main_funcs.php",
    timeout: 5000,
    data: "section=5&id=" + dtype,
    success: function(data) {
    	//alert(data);
    	$("#mod" + dtype).html("<b>ОК</b>");
    },
    error: function(data) {
    	$("#errtd").html("Dept include error!");
    }
  });
}
$(function(){
	var btnUploads = $(".newpic");
	$(btnUploads).each(function() {
		var id = $(this).data("id");
		var page_id = $(this).data("page");
		var block_id = $(this).data("block");
		var row = $(this).data("row");
		var format = $(this).data("format");
		new AjaxUpload(this, {
			action: "xp_upload.php?page_id=" + page_id + "&format=" + format + "&block_id=" + block_id + "&row=" + row + "&id=" + id,
			name: "uploadfile",
			onComplete: function(file, response){
				var arr = response.split("|");
				if (response === "success" || page_id == undefined || arr[0] == block_id + "_" + file) {
					if (page_id == undefined) {
						var tval = $("#" + id).val();
						$("#" + id).selection('replace', {
							text: "<div class=\"timage\"><img src=\"/images/data/" + response + "\" /></div>\n",
							caret: "before"
						});
					}
					if (row == undefined || row == "") {
						$("#picfile" + id).val(block_id + "_" + file);
						$("#pic0_" + id).html("<img width=\"100\" src=\"/images/data/" + arr[0] + "\" alt=\"\" /><span onClick=\"del_pic(" + id + ", " + row + ");\">X</span><br />Размер " + arr[1] + "x" + arr[2] + "px");
					}
					else {
						$("#picfile" + row + "_" + id).val(block_id + "_" + file);
						if (format == 2)
							$("#pic" + row + "_" + id).append("<img width=\"100\" src=\"/images/data/" + arr[0] + "\" alt=\"\" /><span onClick=\"del_pic(" + id + ", " + row + ");\">X</span><br />Размер " + arr[1] + "x" + arr[2] + "px");
						else
							$("#pic" + row + "_" + id).html("<img width=\"100\" src=\"/images/data/" + arr[0] + "\" alt=\"\" /><span onClick=\"del_pic(" + id + ", " + row + ");\">X</span><br />Размер " + arr[1] + "x" + arr[2] + "px");
					}
					// }
					// alert(file);
				}
				else {
					alert("Файл " + file + " не загружен!");
				}
			}
		});
	})
});
function del_pic(id, row) {
  $.ajax({
    type: "POST",
    url: "xp_delpic.php",
    timeout: 5000,
    data: "row=" + row + "&id=" + id,
    success: function(data) {
		if (row == "undefined") {
			$("#pic" + id).empty();
		}
		else {
			$("#pic" + row + "_" + id).empty();
		}
    },
    error: function(data) {
    	$("#errtd").html("Value add error!");
    }
  });
}
$(document).ready(function() {
	$("#sorting").tableDnD({
		onDragClass: "dragRow",
		dragHandle: "dragHandle",
		onDrop: function(table, row) {
			var bid = $("#sort_bid").val();
			var rows = table.tBodies[0].rows;
			var ids = "";
			for (var i = 0; i < rows.length; i++) {
				ids += rows[i].id + "|";
			}
			$.ajax({
			  type: "POST",
			  url: "xp_sort.php",
			  timeout: 5000,
			  data: "bid=" + bid + "&ids=" + ids,
			  success: function(data) {
				$("#sorting tr:odd").removeClass('alt');
				$("#sorting tr:even").addClass('alt');
			  },
			  error: function(data) {
				alert("Error: " + data);
			}
			});
		}
	});
	$("#sorting tr:even").addClass("alt");
	$("#container").sortable({
		axis: "y",
		update: function () {
			var data = "sort=asc";
			$('#container>div').each(function() {    
				var id  = $(this).attr("id");
				data += "&item[]=" + id;
			});
			$.ajax({
				data: data,
				type: "POST",
				url: "xp_sort_.php"
			});
		}
	});
	$(".deptsort").sortable({
		axis: "y",
		update: function () {
			var data = "sort=asc";
			$(this).find('.indent2').each(function() {    
				var id  = $(this).attr("id");
				data += "&item[]=" + id;
			});
			$.ajax({
				data: data,
				type: "POST",
				url: "xp_sort_depts.php"
			});
		}
	});
});
/* отображение формы добавления блока */
function addblock(page_id, parent_id) {
	$("#b_page_id").val(page_id);
	$("#b_parent_id").val(parent_id);
	$("#newblock").fadeIn(200);
}
function addnewblock() {
	var str = "";
	$("#b_form input").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$("#b_form select").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=7" + str,
		success: function(data) {
			if (data.substr(0,5) == "error") {
				alert(data.replace("error:", ""));
			}
			else {
				$("#nodata").hide(0);
				$("#newblock").fadeOut(200);
				var result = data.split("|");
				if ($("#b_parent_id").val() != "" && $("#b_parent_id").val() != 0)
					$("#addelement" + $("#b_parent_id").val()).before("<div class=\"inblock\"><a href=\"?block_id=" + result[0] + "\">" + result[1] + "</a></div>");
				else
					$("#addblock").before("<div class=\"newdiv\"><div class=\"close\"><img src=\"/images/close.png\" onClick=\"if (confirm('Все элементы и вложенные блоки будут также удалены! Вы уверены?')) {delblock(" + result[0] + ");}\" /></div><h3>" + result[1] + "</h3></div>");
				location.reload();
			}
		},
		error: function(data) {
			$("#errtd").html("Block add error!");
		}
	});
}
function editblockprops(bid) {
	var str = "&bid=" + bid;
	$("#b_form_" + bid + " input").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$("#b_form_" + bid + " select").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=12" + str,
		success: function(data) {
			if (data.substr(0,5) == "error") {
				alert(data.replace("error:", ""));
			}
			else {
				$("#nodata").hide(0);
				$("#editprops" + bid).fadeOut(200);
			}
		},
		error: function(data) {
			$("#errtd").html("Block props edit error!");
		}
	});
}
function addelement(block_id) {
	$("#e_block_id").val(block_id);
	$("#newelement").fadeIn(200);
}
function addnewelement() {
	var str = "";
	var block_id = $("#e_block_id").val();
	$("#e_form input").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$("#e_form select").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=8" + str,
		success: function(data) {
			$("#newelement").fadeOut(200);
			$("#addelement" + block_id).before(data);
		},
		error: function(data) {
			$("#errtd").html("Block add error!");
		}
	});
}
function addnewpage() {
	var str = "";
	$("#p_form input").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$("#p_form select").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=11" + str,
		success: function(data) {
			$("#newpage").fadeOut(200);
			$("#adddept").before(data);
			location.reload();
		},
		error: function(data) {
			$("#errtd").html("Page add error!");
		}
	});
}
function editpage(pid) {
	var str = "";
	$("#p_form" + pid + " input").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$("#p_form" + pid + " select").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$("#p_form" + pid + " textarea").each(function(n,element){
		str = str + "&" + $(element).attr("id") + "=" + $(element).val();
	});
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=13&page_id=" + pid + str,
		success: function(data) {
			$("#editpage" + pid).fadeOut(200);
			// location.reload();
		},
		error: function(data) {
			$("#errtd").html("Page edit error!");
		}
	});
}
function delpage(pid) {
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=2&page_id=" + pid,
		success: function(data) {
			$("#page" + pid).fadeOut(200, function() {
				$("#page" + pid).remove();
			});
			$("#content").html("Страница удалена! Выберите другую из списка или перейдите на <a href=\"main.php\">главную</a>");
		},
		error: function(data) {
			$("#errtd").html("Page del error!");
		}
	});
}
function delblock(block_id) {
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=9&block_id=" + block_id,
		success: function(data) {
			$("#block" + block_id).fadeOut(500);
		},
		error: function(data) {
			$("#errtd").html("Block del error!");
		}
	});
}
function delelement(eid, block_id) {
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=10&eid=" + eid + "&block_id=" + block_id,
		success: function(data) {
			$("#element" + eid + "_" + block_id).fadeOut(500);
		},
		error: function(data) {
			$("#errtd").html("Element del error!");
		}
	});
}
function checklistitem(field, order, item, itemval, ch) {
	var val = $('#hiddenlist' + order + '_' + field).val();
	if (ch === true) {
		var newval = val.replace('*', '');
		var newval = newval.replace(itemval, '*' + itemval);
		// $('.lelement' + order + '_' + field).removeAttr('checked');
		// $('#chb' + order + '_' + field + '_' + item).attr('checked', 'checked');
	}
	else {
		var newval = newval.replace('*' + itemval, itemval);
	}
	$('#hiddenlist' + order + '_' + field).val(newval);
}
function addlistitem(field, format, order, item) {
	if (item != "") {
		if (order == 0)
			{
			var val = $('#hiddenlist' + field).val();
			var arr = val.split('^');
			if (val == '')
				var len = 1;
			else
				var len = arr.length + 1;
			if (val != '') {
				val += '^';
			}
			val += item;
			$('#hiddenlist' + field).val(val);
			var html = '<div class=\'lelement\' id=\'lelement' + field + '_' + len + '\'>' + item + '&nbsp;<button onClick=\'dellistitem(' + field + ', 0, ' + len + '); return false;\'>X</button>';
			$('#list' + field).before(html);
		}
		else {
			var val = $('#hiddenlist' + order + '_' + field).val();
			var arr = val.split('^');
			if (val == '')
				var len = 1;
			else
				var len = arr.length + 1;
			if (val != '') {
				val += '^';
			}
			val += item;
			$('#hiddenlist' + order + '_' + field).val(val);
			var html = '<div class=\'lelement\' id=\'lelement' + order + '_' + field + '_' + len + '\'>' + item + '&nbsp;<button onClick=\'dellistitem(' + field + ', ' + order + ', ' + len + '); return false;\'>X</button>';
			$('#list' + order + '_' + field).before(html);
		}
	}
}
function dellistitem(field, order, lkey) {
	// доработать множественное удаление, сейчас не работает!
	if (order == 0)
		{
		var val = $('#hiddenlist' + field).val();
		arr = val.split('^');
		arr.splice(lkey - 1,1);
		var newval = arr.join('^');
		$('#hiddenlist' + field).val(newval);
		$('#lelement' + field + '_' + lkey).remove();
	}
	else {
		var val = $('#hiddenlist' + order + '_' + field).val();
		arr = val.split('^');
		arr.splice(lkey - 1,1);
		var newval = arr.join('^');
		$('#hiddenlist' + order + '_' + field).val(newval);
		$('#lelement' + order + '_' + field + '_' + lkey).remove();
	}
}
function insertvideo(id) {
	var tval = $("#" + id).val();
	var vval = prompt("Введите код видео с Youtube:");
	var insval = "<iframe width=\"500\" height=\"280\" src=\"https://www.youtube.com/embed/" + vval + "\" frameborder=\"0\" allowfullscreen></iframe>";
	if (vval.substring(0,4) == "http")
		insval = "<iframe width=\"500\" height=\"280\" src=\"" + vval + "\" frameborder=\"0\" allowfullscreen></iframe>";
	if (vval.substring(0,7) == "<iframe")
		insval = vval;
	$("#" + id).selection('replace', {
		text: "<div class=\"tvideo\">" + insval + "</div>\n",
		caret: "before"
	});
}
function add_lang(lang, shrt) {
  $.ajax({
    type: "POST",
    url: "xp_main_funcs.php",
    timeout: 5000,
    data: "section=14&lang=" + lang + "&shrt=" + shrt,
    success: function(data) {
		$("#addlang").before("<div class=\"group\"><div class=\"ttl\">" + lang + "</div><div class=\"ttl\">" + shrt + "</div><div class=\"fld\"><img onClick=\"edit_lang(" + data + ")\" src=\"images/edit.svg\" width=\"25\" height=\"25\" border=\"0\" alt=\"" + MSG[lng]["TTLEditLang"] + "\" /></div><div class=\"fld\"><img onClick=\"if (confirm('" + MSG[lng]["ConfDelLang"] + "'))	{del_lang(" + data + ")'}};\" src=\"images/delete.svg\" width=\"24\" height=\"24\" border=\"0\" alt=\"" + MSG[lng]["TTLDeleteLang"] + "\" /></div></div>");
		$("#lang_name").val('');
		$("#lang_short").val('');
    },
    error: function(data) {
    	$("#errtd").html("Lang add error!");
    }
  });
}
function del_lang(lang_id) {
  $.ajax({
    type: "POST",
    url: "xp_main_funcs.php",
    timeout: 5000,
    data: "section=15&lang_id=" + lang_id,
    success: function(data) {
		$("#lang" + lang_id).remove();
    },
    error: function(data) {
    	$("#errtd").html("Lang del error!");
    }
  });
}
function takedata(block_id, lang_id, new_lang_id) {
  $.ajax({
    type: "POST",
    url: "xp_main_funcs.php",
    timeout: 5000,
    data: "section=16&lang_id=" + lang_id + "&block_id=" + block_id + "&new_lang_id=" + new_lang_id,
    success: function(data) {
		alert("Done!");
    },
    error: function(data) {
    	$("#errtd").html("Data take error!");
    }
  });
}
function setmodule(eid, mid) {
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=17&eid=" + eid + "&mid=" + mid,
		success: function(data) {
			$("#allmodules" + eid).fadeOut("fast");
			$(".mask").fadeOut("fast");
			location.reload();
		},
		error: function(data) {
			$("#errtd").html("Module link error!");
		}
	});
}
function addfitem(field, fitem, fcnt) {
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=18&field=" + field + "&fitem=" + fitem,
		success: function(data) {
			$("#newfitem" + field).before("<div class=\"fitem\" id=\"fitem" +  field + "_" + fcnt + "\">" + fitem + "&nbsp;<img onClick=\"delfitem(" + field + ", " + fcnt + ");\" src=\"images/delete.svg\" /></div>");
			$(".lelement" + field).append($('<option></option>').val(fcnt).html(fitem));
		},
		error: function(data) {
			$("#errtd").html("Fitem add error!");
		}
	});
}
function delfitem(field, fcnt) {
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=19&field=" + field + "&fcnt=" + fcnt,
		success: function(data) {
			$("#fitem" + field + "_" + fcnt).remove();
			$(".lelement" + field + " option[value='" + fcnt + "']").remove();

		},
		error: function(data) {
			$("#errtd").html("Fitem del error!");
		}
	});
}
function moveblock(bid, to) {
	$.ajax({
		type: "POST",
		url: "xp_main_funcs.php",
		timeout: 5000,
		data: "section=20&bid=" + bid + "&to=" + to,
		success: function(data) {
			location.reload();
		},
		error: function(data) {
			$("#errtd").html("Fitem del error!");
		}
	});
}
