<?php


namespace Xaveere\framework\Database;


use Xaveere\framework\Query\MySqlQueryBuilder;
use Xaveere\framework\Query\QueryBuilder;

trait DatabaseResolver
{

    /**
     * Sınıfın kalıtımını yapacak yer.
     * @var DatabaseResolver|null
     */
    protected static $instance = NULL;

    /**
     * Çağırılan sınıfın kalıtımını alıyor, (Model) sınıfı
     * DatabaseResolver constructor.
     */
    public function __construct()
    {
        if (is_null(self::$instance))
        {
            $class = get_called_class();
            return self::$instance = new $class;
        }

        return self::$instance = $this;
    }


    /**
     * Topluluğu bootstrap yapmak için kullanılacak.
     */
    public static function boot()
    {
        self::ResolveTable();

    }

    /**
     * Query Builder'a tablo adı olarak, ResolveTable dan gelen sınıf adını veriyor.
     */
    public static function ResolvedTableName()
    {

        self::registerQueryBoot()
            ->setTable(self::ResolveTable());
    }


    /**
     * Çağırıldığı sınıfın(Model'in) adını, tablo adı olarak alıyor.
     * @return string
     */
    public static function ResolveTable()
    {
        $table_name = null;
        // explode ile yürütülen işlem daha sonra
        // Kendi string, array sınıfımda tanıtılacak ve oradan kullanılacak.

        $called_model_string = get_called_class();

        $called_model_array = explode("\\", $called_model_string); // App/Models/{ModelName};
        $table_name = strtolower($called_model_array[2]); // Burada tablo ismini küçük tutmalıyız. ne geleceğeni bilemeyiz.

        // Helpera taşınacak
        if (strpos($table_name, '_') !== false) {
            $called_model_array = explode('_', $table_name);
        }

        if (preg_match_all('/((?:^|[A-Z])[a-z]+)/', $table_name)) {
            $called_model_array = preg_split('/(?=[A-Z])/', $table_name);
        }

        self::lowerRecursively($called_model_array, $table_name);

        return $table_name;
    }

    private static function lowerRecursively(array &$par, string &$to)
    {
        $response = implode("_", $par);
        $par = null;
        return $response;
    }


    /**
     * Query Builder kalıtımı yapılıp Model'e aktarılıyor.
     * @param string $table
     * @return QueryBuilder
     */
    public static function registerQueryBoot($table = "")
    {
        return self::registerQueryGlobalScopes(new MySqlQueryBuilder($table));
    }

    /**
     * Query Builder Interface i kullanılarak registerQueryBoot a zemin hazırlıyor
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public static function registerQueryGlobalScopes(QueryBuilder $builder)
    {
        return $builder;
    }
}