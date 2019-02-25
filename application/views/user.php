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
          <?php foreach($this->request->errors['email'] as $errors): ?>
            <v-alert type="error" dismissible :value="true">
              <?= ucfirst($errors) ?>
           </v-alert>
          <?php endforeach; ?>
  	  		<?= form_open("profile/form_submit", "POST") ?>
  	  			<div>
  	  				<?= form_input([
	  	  				'name' => 'email',
                'type' => 'email',
	  	  				'label' => 'Enter your email',
	  	  			], 'v-text-field') ?>
  	  			</div>
	  	  		<?= form_input([
	  	  			'label' => 'Send data',
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