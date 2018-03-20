<?php

use Core\Forms\ExampleForm;
use Core\Helpers\HtmlHelper;

$html = new HtmlHelper();
$form = new ExampleForm($_POST);
$form->handle();

?>

<div class="form">
	<div class="form__header">
		<h2 class="form__title">Форма логина</h2>
	</div>

	<form action="{{ $form->getUrl() }}" method="post" class="form__fields">
		{!! $form->getHiddenFields() !!}

		<div class="form__field">
			<input type="text" name="user_email" value="{{ $form->getEmail() }}" class="input" placeholder="Your email">
		</div>

		<div class="form__field">
			<input type="text" name="user_login" value="{{ $form->getLogin() }}" class="input" placeholder="Your login">
		</div>

		<div class="form__field">
			<input type="submit" value="Submit" class="form__submit">
		</div>
	</form>

	<div class="form__result {{ $form->hasErrors() ? 'form__result--error' : 'form__result--success'  }}">
		@foreach($form->getMessages() as $message)
			{{ $message }}
		@endforeach

		@foreach($form->getErrorsMessage() as $message)
			{{ $message }}
		@endforeach
	</div>
</div>
