<div class="feedback_div">
	<div class="feedback_line group">
		<h2><?=$fields["header"];?></h2>
	</div>
	<div class="f_text"><?=$fields["text"];?></div>
	<div class="f_err" id="f_err"></div>
	<form name="feedback" action="/" onSubmit="sendform(); return false;" method="post">
		<div class="fform group">
			<div class="fb_left">
				<input name="name" id="name" placeholder="Как Вас зовут" />
				<input name="contact" id="contact" placeholder="Телефон или email" />
			</div>
			<div class="fb_left">
				<textarea name="message" id="message" placeholder="Ваше сообщение"></textarea>
			</div>
			<div class="fb_left1">
				<button>Отправить</button>
			</div>
		</div>
	</form>
</div>
