
<p align="center">
  <img src="https://lh3.googleusercontent.com/qrUAvRk1WXw2ht4uDdY35WVIm4JyD2I_pujxF1Cv81jvcpj_54L19me2Mya_H8uIg7HOXXDE4aakCZgpIJIEgBEnel4HJwNyTsXSih_mWc-40awi_tyP8Zf8pkcbuWwRTJpGFXbutRlOR3hZXAsrhQCa_T9b1EQyZNeuOJuxqsHMqFK7h0nxF0DYGIs-MT7ZUsfjbXm9N4rE3lcZnTNvLujiIvsme_7F03F50XTuOvrfkwsd11GsBJLXPmeIgxScc--Q5SgYzhYkPGaNTuaU8rDuEstzS1-iiLt4gDv7hAoVGYCJ8QidtAFHu3Jq9riYBb7FvAsnFZvHOQKsaM5ubZWRQOpydXDk2tBDajopDUK4X457vPZZeCIEzrRAXFtiTZUvGD0vY01s_NXvQ9EMkcpU0FToly4iRicejyEsGSg7caRPJV-EQzLUUZ9CLq2EYQWn_gPNWW2KkuH3IA12cSMax3nchh6bCC7RiD_H7_ga_hYdIyGJEMBqLh73WCkhLZVZ5BGgttXMIKbqPPVCK3Z3EbXBFn76AG-BYRKLX1GUei67OmxDHCwNg8MQRDv9763fSJXuAlBX6C6AG8Yses8GNHD9ssEwymxY9EQlhQCaGRsE98RaRz39Vg4s0O198301mYn68xE7Amx0l7Z6yitYpd0alHju=w149-h173-no" alt="Xaveere Micro Web Framework"/>
</p>
<p align="center">
  # Xaveere
</p>

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

