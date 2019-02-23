<?php 


/**
 * Example usage for Bootstrap Library: *** Component: Text Field
 * form_input([
		'id' => 'input-id',
		'name' => 'name',
		'class' => 'form-control',
		'placeholder' => 'Enter name',
		'value' => '',
	])
 * @return <input .../> Object.
 */

/**
 * Example usage for Bootstrap Library: *** Component: Button
 * form_input([
		'id' => 'input-id',
		'name' => 'name',
		'class' => 'form-control',
		'type' => 'submit',
		'value' => 'Click Me',
	])
 * @return <input .../> Object.
 */

/**
 * Example usage for Bootstrap Library: *** Component: Button
 * form_input([
		'id' => 'input-id',
		'name' => 'name1',
		'placeholder' => 'Go to Google',
		'href' => 'https://www.google.com',
		'extension' => 'target="blank"'
	], 'a')
 * @return <a $extension>$slot</a> Object.
 */

/**
 * Example usage for Vuetify Library: *** Component: Text Field
 * form_input([
		'name' => 'name',
		'label' => 'Enter name',
		'value' => '',
	], 'v-text-field')
 * @return <v-text-field .../> Object
 */

/**
 * Example usage for Vuetify Library: *** Component: Button
 * form_input([
		'name' => 'name',
		'label' => 'Enter name',
		'value' => '',
	], 'v-btn')
 * @return <v-btn ...></v-btn> Object
 */

/**
 * Example usage for Vuetify Library: *** Component: Button with $slot
 * In this case you don't need to write 'label' or 'placeholder' 
 * For Button's name(click name)
 * basically you can use 3. parameter as a Button's name.
 * form_input([
		'name' => 'name',
		'value' => '',
	], 'v-btn', 'Enter name')
 * @return <v-btn ...>$slot</v-btn> Object
 */

/**
 * Example usage for Vuetify Library: *** Component: Button with $extension
 * In this case you don't need to write 'label' or 'placeholder' 
 * For Button's name(click name)
 * basically you can use 3. parameter as a Button's name.
 * form_input([
		'name' => 'name',
		'label' => 'Click me',
		'extension' => 'color="red" class="ma-2 pa-2... something else"'
	], 'v-btn')
 * @return <v-btn $extension></v-btn> Object
 */


/**
 * Example usage for Vuetify Library: *** Component: Button with $extension
 * In this case you don't need to write 'label' or 'placeholder' 
 * For Button's name(click name)
 * basically you can use 3. parameter as a Button's name.
 * You can even use '@click' method with specific javascript 'method'
 * form_input([
		'id' => 'input-id',
		'name' => 'name',
		'label' => 'Click me',
		'extension' => ' color="red"',
		'@click' => 'alert()'
	], 'v-btn')
 * In Vue;
 * methods:{
  	alert(){
  		alert("Hello world");
  	}
  }
 * @return <v-btn $extension></v-btn> Object
 */

/**
 * $extension might be used for v-model or something else that you can use 
 * in Vuetifyjs 
 *
 * <v-text-field $extension></v-text-field> is might be like that
 * <v-text-field v-model="name" box prepend-icon="icon"></v-text-field>
 */
function form_input($fields, $type_of_input = "", $slot = ""){

	// Fields be like;
	/*
		[
  			'id' => 'input-id',
  			'name' => 'name',
  			'class' => 'form-controler',
  			'placeholder' => 'Enter name',
  			'value' => ''
  		]
	*/
  	
  	// We need to make a comparision with $fields variable's $key
  	// And $must_be_keys variable's $value.
	$must_be_keys = FORM_KEYS;

	$vals = "";
	empty($type_of_input) 
	? $type_of_input = "input" 
	: $type_of_input;
	foreach($fields as $key => $value):
		foreach($must_be_keys as $keys):
		  if ($keys == $key) {
		  	$vals .= "{$key}='{$value}' ";
		  }
		endforeach;
	endforeach;
	// Concatenate values to $extension
	empty($fields['extension'])
	? $vals
	: $vals .= "{$fields['extension']}";

	// dizide 'placeholder' a ait değeri bul.

	preg_match("/\placeholder='(.*?)'/", $vals, $placeholder);
	//  placeholder='Text', $placeholder[1] = 'Text';
	if (empty($placeholder[1])) {
		preg_match("/\label='(.*?)'/", $vals, $placeholder);
	}

	empty($slot) && !empty($placeholder[1])
	? $slot = $placeholder[1] // $slot = "Text";
	: $slot; // $slot;

	/*if (empty($slot) && !empty($placeholder[1])) { // $slot = "" ve $placeholder = "sad"
		$slot = $placeholder[1];
	}*/



	if ($type_of_input == "input" || $type_of_input == "v-text-field") {
		return "<{$type_of_input} {$vals}/>";
	} else {
		return "<{$type_of_input} {$vals}>
					{$slot}
				</{$type_of_input}>";
	}
}


/**
 * Example usage: form_open("profile/testMethod", "GET");
 * Example usage with $options = "": form_open("profile/testMethod", "GET", "class='form-control'")
 * 
 * You can even add $options="enctype='multipart/form-data'" "
 * @param $action = "GET|POST|PUT|PATCH"
 * @param $method = "controller/method"
 * @param $options = "class='form-control'"
 */
function form_open($action, $method, $options = "")
{
	$url = "/" . SERVER_NAME . BASE_PATH . $action;

	return "<form method='{$method}' action='/{$url}' {$options} >";
}


function form_close()
{
	return "</form>";
}