<!DOCTYPE html>
<html>
<head>
	<title>Index page</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

</head>
<body>
  <div id="app">
  	<v-app>
  	  <v-content>
  	  	<v-container fluid>
  	  	  <v-list>
  	  	  	<?php foreach($data as $user): ?>
  	  	    <v-list-tile>
  	  	      <v-list-tile-title><?= $user->name ?></v-list-tile-title>
  	  	      <v-list-tile-sub-title><?= $user->address ?></v-list-tile-sub-title>
  	  	    </v-list-tile>
  	  		<?php endforeach; ?>
  	  	  </v-list>
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