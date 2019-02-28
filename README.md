# Xaveere
<p align="center">
  <img src="https://lh3.googleusercontent.com/pfJCGb0Bi3pkl1NUADmHAm7M303lQoJiMF8bkfh-95O0UTbvCnIVm_f6F9VLTdFanUpiMOcB9JQsbSfEVN1E4oM_3Yuc3ckQZL3Gs9PXYU1z3mh_T7sfeODguhrviLWu9DakWziM18spLqBOiiypRgyfAJZRTeYcFI7yd1T-CC4EuYvqm4XSU2juQYePZkZIs7usF1S9pDjnLoW8860CeAyinbGBs0iqTZ_ba31ngbNC1KmqJWUY-_mjP2Vo7PJ6wbmxzCVTXBvp3KHm-1QAuwOL3K24KHbUHHJpLPmdNAjEuSxg_t--4WETjxJxfY8xA72NOwxj_hsD8FN8TvFa4rDhZwClCrUnb3USvTd9YSCujmixOE_mKtp_noV9_ZIiKD7sA9jfNngnof0MvbTZRzv_UkK6nhI6pT0AbRMB5M62JGeCOu5Se0RbyUclVfON4_aknPBiwDvQaRIiFIJOHQI1b8ENs-Qyhmwetm_TjSXSuYKuPsIOMS3oJm3XCOTk9_FJxjYDTS97xPLHDV7zGZgYul9XKaDfgER8yqvYP88OWdzdNY8JUxvms9kBjW2xY5bZA6aqUk2u5hKgt6de8SiiVaVnlhP04a2LmSAgX53Kwj18R-m_veWJEIrYyCcBkQmG99WJKqrEpdPl4tFuagxS6YBIw1sz=s250-k-no" alt="Xaveere Micro Web Framework"/>
</p>


### Configure Your Database Connection
application/config/config.php
```
$database = [
	"CONNECTION_TYPE" => "mysql",
	"HOST" => "localhost",
	"DATABASE" => "DATABASE_NAME",
	"USERNAME" => "DATABASE_USERNAME",
	"PASSWORD" => "DATABASE_PASSWORD"
];
```

## Define a Route
### Xaveere is requiring Controllers automatically.
This route's path is: 'http://localhost/user'
```
class User extends Xaveere
{

	public function index()
	{
		$this->view("user/index");
	}
}
```


## Define a Model
### Database queries didn't write with Builder Pattern.
### It's very sooon feature.
```
class Users extends Database 
{
	public function get_users()
	{
		
		$this->select();
		$rows = $this->allRecords();
		return $rows;
		
	}
}
```

## Receiving user requests
```
<?php
$data = Request::all();
$this->store($data);
?>
```

## Validation and its rules
### Pre-defined rules
```
required
string
int
min|255
max|255
confirm|password
unique|users
```
### Using rules 
```
$request = new Request;
$request->validate([
	'name' => 'required',
	'age' => 'required'
]);
```
### Confirm password rule.
```
$request = new Request;
$request->validate([
	'password' => 'required',
	'password_confirm' => 'confirm|password|required'
]);
# 'confirm|password': password = "which input will be checked for this input to make them match."
```
### Unique E-mail rule.
```
$request = new Request;
$request->validate([
	'email' => 'required|unique|users'
]);
#'unique|users': users = "which 'table' will be checked for this input's value to make them match and their existing."
```

## Form Helper
### Xaveere is supporting Bootstrap, Vuetify and pure, user defined styling.
### Text field(Bootstrap)
```
<?php
form_input([
	'id' => 'input-id',
	'name' => 'name',
	'class' => 'form-control',
	'placeholder' => 'Enter name',
	'value' => '',
]);
?>
```

### Button(Bootstrap)
```
<?php
form_input([
	'id' => 'input-id',
	'name' => 'name',
	'class' => 'form-control',
	'type' => 'submit',
	'value' => 'Click Me',
]);
?>
```
### Anchor(Bootstrap)
```
@return <a $extension>$slot</a>
<?php
form_input([
	'id' => 'input-id',
	'name' => 'name1',
	'placeholder' => 'Go to Google',
	'href' => 'https://www.google.com',
	'extension' => 'target="blank"'
], 'a');
?>
```

### Text field(Vuetify)
```
<?php 
form_input([
	'name' => 'name',
	'label' => 'Enter name',
	'value' => '',
], 'v-text-field');
?>
```

### Button(Vuetify)
```
# For Button's name(click name)
# basically you can use 3. parameter as a Button's name.
<?php 
form_input([
	'name' => 'name',
	'label' => 'Click me',
	'extension' => 'color="red" class="ma-2 pa-2... something else"'
], 'v-btn');
# @return <v-btn $extension></v-btn>
```

### Button with Javascript event(Vuetify)
```
 # You can even use '@click' method with specific javascript 'method'

 <?php 
 form_input([
	'id' => 'input-id',
	'name' => 'name',
	'label' => 'Click me',
	'extension' => ' color="red"',
	'@click' => 'alert()'
], 'v-btn');
?>
 # In Vue;
 methods:{
  	alert(){
  		alert("Hello world");
  	}
  }
 # @return <v-btn $extension></v-btn>
```

### Deep into '$extension'
```
/**
 * $extension might be used for v-model or something else that you can use 
 * in Vuetifyjs 
 *
 * <v-text-field $extension></v-text-field> is might be like that
 * <v-text-field v-model="name" box prepend-icon="icon"></v-text-field>
 */
```

### Form open/clode
```
<?= form_open("user/store", "POST"); ?>
  ... form inputs
<?= form_close() ?>
```

## File helper
```
/*
'timestamp' => true
option can be used for concatenate with 'time() . $file_name' 
*/
$data = [
  'file_name' => 'image',
  'allowed_extensions' => 'jpg|png',
  'upload_path' => 'images/'
];

$this->file($data);

// Look if there are any errors while uploading a file.
$this->errors();
```


## First Program Via Vuetify
index.php(View):
```
<v-list>
 <?php foreach($data as $user): ?>
  <v-list-tile>
    <v-list-tile-title><?= $user->name ?></v-list-tile-title>
    <v-list-tile-sub-title><?= $user->address ?></v-list-tile-sub-title>
  </v-list-tile>
 <?php endforeach; ?>
</v-list>
```

profile.php(Controller):
```
private $store_model;
function __construct()
{
	parent::__construct();
	$this->store_model = $this->model("users");
}

public function index()
{
	$data = $this->store_model->fetch_records();
	$this->view("index", $data);

}
```

Users.php(Model):
```
public function fetch_records()
{
	
	$this->select();
	$rows = $this->allRecords();
	return $rows;
	
}
```

### Live your application
Goto application/config/config.php
```
$settings = [
	// Set BASE_PATH to '/'
	"BASE_PATH" => "/",
	...
];
```

