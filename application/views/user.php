<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>User View</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

	<link rel="stylesheet" href="<?= _public("css/style.css") ?>">
</head>
<body>
  <div id="app">
  	<v-app>
  	  <v-content>
  	  	<v-container fluid>
  	  		<?= form_open("profile/testMethod", "GET") ?>
	  	  		<?= form_input([
	  	  			'id' => 'input-id',
	  	  			'name' => 'name1',
	  	  			'type' => 'file',
	  	  		]) ?>
	  	  		<?= form_input([
	  	  			'id' => 'input-id',
	  	  			'name' => 'name1',
	  	  			'placeholder' => 'ANA SQM',
	  	  			'href' => 'https://www.google.com',
	  	  			'extension' => 'target="blank"'
	  	  		], 'a') ?>
	  	  		<?= form_input([
	  	  			'id' => 'input-id',
	  	  			'name' => 'name',
	  	  			'label' => 'Click me2',
	  	  			'type' => 'submit',
	  	  			'extension' => 'dark color="black"',
	  	  		], 'v-btn') ?>
	  	  	<?= form_close() ?>
  	  	</v-container>
  	  </v-content>
  	</v-app>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
  <script>
    new Vue({ 
      el: '#app',
      data(){
      	return {
      	  valid: false,
      	}
      },
      methods:{
      	alert(){
      		alert("Hello world");
      	}
      }
    });
  </script>
</body>
</html>