<?php

Form::macro('rawLabel', function($name, $value = null, $options = array())
{
	$label = Form::label($name, '%s', $options);
	return sprintf($label, $value);
});

Form::macro("field", function($options)
{
	$markup = "";

	$type = "text";

	if (!empty($options["type"]))
	{
		$type = $options["type"];
	}

	if (empty($options["name"]))
	{
		return;
	}

	$name = $options["name"];

	$label = "";

	if (!empty($options["label"]))
	{
		$label = $options["label"];
	}

	if (empty($label) && empty($options['no_label'])) {
		$label = str_replace( '_', ' ', ucwords( $name ) );
	}

	$value = Input::old($name);

	if (!empty($options["value"]))
	{
		$value = Input::old($name, $options["value"]);
	}

	// if (!empty($options["selected"]))
	// {
	// 	// $value = Input::old($name, $options["selected"]);
	// }

	$placeholder = "";

	if (!empty($options["placeholder"]))
	{
		$placeholder = $options["placeholder"];
	}

	$class = "";

	if (!empty($options["class"]))
	{
		$class = " " . $options["class"];
	}

	$parameters = [
		"class"       => "form-control" . $class,
		"placeholder" => $placeholder
	];

	if (!empty($options['parameters'])) {
		$parameters = array_merge( $parameters, $options['parameters'] );
	}

	$error = "";

	if (!empty($options["error"]))
	{
		$error = $options["error"]->has($name) ? $options["error"]->first($name) : NULL;
	}

	if ($type !== "hidden")
	{
		$markup .= "<div class='form-group";
		$markup .= ($error ? " has-error" : "");
		$markup .= "'>";
	}

	switch ($type)
	{
		case "text":
			if (empty($options['no_label'])) {
				$markup .= Form::rawLabel($name, $label, [
					"class" => "control-label"
				]);
			}
			$markup .= Form::text($name, $value, $parameters);
			break;

		case "textarea":
			if (empty($options['no_label'])) {
				$markup .= Form::rawLabel($name, $label, [
					"class" => "control-label"
				]);
			}
			$markup .= Form::textarea($name, $value, $parameters);
			break;

		case "password":
			if (empty($options['no_label'])) {
				$markup .= Form::rawLabel($name, $label, [
					"class" => "control-label"
				]);
			}
			$markup .= Form::password($name, $parameters);
			break;

		case "checkbox":
			$markup .= "<div class='checkbox'>";
			if (empty($options['no_label'])) {
				$markup .= "<label>";
			}

			$selected = ! empty( $options['selected'] ) ? $options['selected'] : false;
			$value = ! empty( $value ) ? $value : 1;
			$markup .= Form::checkbox($name, $value, (boolean) $selected);

			if (empty($options['no_label'])) {
				$markup .= " " . $label;
				$markup .= "</label>";
			}
			$markup .= "</div>";
			break;

		case "hidden":
			$markup .= Form::hidden($name, $value);
			break;

		case "select":
			if (empty($options['no_label'])) {
				$markup .= Form::rawLabel($name, $label, [
					"class" => "control-label"
				]);
			}

			if ( ! in_array( 'multiple', $parameters ) ) {
				$options['options'] = [NULL => 'Choose an option'] + $options['options'];
			}
			$markup .= Form::select($name, $options['options'], $value, $parameters);
			break;

		case "radio":
			$markup .= "<div class='radio'>";
			if (empty($options['no_label'])) {
				$markup .= "<label>";
			}

			$selected = ! empty( $options['selected'] ) ? $options['selected'] : false;
			$markup .= Form::radio($name, $value, (boolean) $selected);

			if (empty($options['no_label'])) {
				$markup .= " " . $label;
				$markup .= "</label>";
			}
			$markup .= "</div>";
			break;
	}

	if ($error) {
		$markup .= "<span class='help-block'>";
		$markup .= $error;
		$markup .= "</span>";
	}

	if ($type !== "hidden") {
		$markup .= "</div>";
	}

	return $markup;
});


HTML::macro( 'submit', function( $value = null, $options = [] )
{
	$options['class'] = ! empty( $options['class'] ) ? 'btn btn-info ' . $options['class'] : 'btn btn-info';
	return Form::input( 'submit', null, $value, $options );
});

HTML::macro( 'snippets', function( $snippets, $show_pagination = true )
{
	include( app_path() . '/views/partials/snippets.php');

	if ( $show_pagination ) {
		echo $snippets->links();
	}
});