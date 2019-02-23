# Xaveere

## First Program With Vuetify
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

