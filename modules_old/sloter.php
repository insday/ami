<script>
$(document).ready(function() {
	startSpins();
});
var outtime = 140;
var time = 1000;
changing = new Array();
changing[1] = 0;
changing[2] = 0;
changing[3] = 0;
timeout = new Array();
timeout[1] = 0;
timeout[2] = 0;
timeout[3] = 0;
buts = new Array();
buts[0] = "Попробуй еще раз";
buts[1] = "А еще разок слабо?";
buts[2] = "Давай, жми снова";
buts[3] = "Можно нажать еще";
buts[4] = "Крутани барабан";
buts[5] = "Давай, жми еще раз";
buts[6] = "А ну-ка еще разок!";
words = new Array();
words[1] = new Array();
words[1][0] = "РАЗРАБАТЫВАЕМ";
words[1][1] = "КОНСТРУИРУЕМ";
words[1][2] = "ИЗОБРЕТАЕМ";
words[1][3] = "РИСУЕМ";
words[1][4] = "РАЗВИВАЕМ";
words[2] = new Array();
words[2][0] = "ТЕХНОЛОГИЧНЫЕ";
words[2][1] = "КРАСИВЫЕ";
words[2][2] = "ПРОДАЮЩИЕ";
words[2][3] = "ПРАВИЛЬНЫЕ";
words[2][4] = "ИНТЕРЕСНЫЕ";
words[3] = new Array();
words[3][0] = "ПРОЕКТЫ";
words[3][1] = "РЕСУРСЫ";
words[3][2] = "ЛЕНДИНГИ";
words[3][3] = "ПОРТАЛЫ";
words[3][4] = "ВЕБСЕРВИСЫ";
function changeWord(n) {
	var count = words[n].length;
	var randomVal = (Math.random() * count);
	var index = Math.ceil(randomVal) - 1;
	$("#blow" + n).text(words[n][index]);
}
function changeWords(n) {
	var count = words[n].length;
	var randomVal = (Math.random() * count);
	var index = Math.ceil(randomVal) - 1;
	$("#spinner-inner" + n + " ul li").text(words[n][index]);
	var timeout0 = setTimeout(function() {
		clearTimeout(timeout0);
		if (changing[n] == 1)
			changeWords(n);
	}, 60);
}
function startSpins() {
	$("#but").attr("disabled", "disabled");
	$("#but").fadeOut(500);
	$("#maintext").fadeOut(500);
	$("#slotmach img").animate({"margin-top": -100, opacity: 0}, outtime, function() {
		$("#blow1").animate({"right": 400, opacity: 0}, outtime, function() {
			$("#blow2").animate({"top": -200, opacity: 0}, outtime, function() {
				$("#blow3").animate({"left": 400, opacity: 0}, outtime, function() {
					changeWord(1);
					changeWord(2);
					changeWord(3);
					$("#blow_1").css("width", $("#blow1").width());
					$("#blow_2").css("width", $("#blow2").width());
					$("#blow_3").css("width", $("#blow3").width());
					$("#blow1").animate({"right": 0, opacity: 1}, outtime, function() {
						$("#blow2").animate({"top": 0, opacity: 1}, outtime, function() {
							$("#blow3").animate({"left": 0, opacity: 1}, outtime, function() {
								var count = buts.length;
								var randomVal = (Math.random() * count);
								var index = Math.ceil(randomVal) - 1;
								$("#but").text(buts[index]).removeAttr("disabled");
								$("#but").fadeIn(500);
								$("#maintext").fadeIn(500);
								$("#slotmach img").animate({"margin-top": 0, opacity: 1}, outtime);
							});
						});
					});
				});
			});
		});
	});
	/*
	for (i = 1; i <= 3; i++)
		{
		startSpin(i);
		$("#but").attr("disabled", "disabled");
	}
	*/
}
function startSpin(n) {
	$("#spinner-inner" + n + " ul li").addClass('rotating');
	changing[n] = 1;
	changeWords(n);
	timeout[n] = setTimeout(function() {
		clearTimeout(timeout[n]);
		endSpin(n);
		changing[n] = 0;
	}, time * n);
}
function endSpin(id) {
	$("#spinner-inner" + id + " ul li").removeClass("rotating");
	if (id == 3) {
		var count = buts.length;
		var randomVal = (Math.random() * count);
		var index = Math.ceil(randomVal) - 1;
		$("#but").text(buts[index]).removeAttr("disabled");
	}
}
</script>
<div id="content">
	<?
	if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"]))
		{
		?>
		<div class="sloter_back"><img src="/images/data/<?=$fields["back"];?>" /></div>
		<?
	}
	?>
	<div class="abs">
		<div class="sloter group">
			<div id="slotmach" class="slotmach"><img src="/images/icon.png" /></div>
			<div id="blowing" class="blowing">
				<div id="blow_1" class="blow"><div id="blow1">ПРОЕКТИРУЕМ</div></div>
				<div id="blow_2"  class="blow"><div id="blow2">УДОБНЫЕ</div></div>
				<div id="blow_3"  class="blow"><div id="blow3">ИНТЕРФЕЙСЫ</div></div>
			</div>
		</div>
		<div id="create">
			<div id="maintext"><?=$fields["text"];?></div>
			<div class="again">
				<img onClick="startSpins();" src="/images/again.png" />
				<span onClick="startSpins();">А ну-ка еще разок!</span>
			</div>
		</div>
		<div id="sbuttons" class="group">
			<div id="sbutton"></div>
		</div>
	</div>
</div>
<?
$mcnt = 0;
foreach ($subfields as $subfield)
	{
	?>
	<?
}
?>
