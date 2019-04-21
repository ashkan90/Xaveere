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
        // explode ile yürütülen işlem daha sonra
        // Kendi string, array sınıfımda tanıtılacak ve oradan kullanılacak.

        $called_model = get_called_class();

        $called_model = explode("\\", $called_model); // App/Models/{ModelName};
        $called_model[2] = strtolower($called_model[2]); // Burada tablo ismini küçük tutmalıyız. ne geleceğeni bilemeyiz.


        return $called_model[2];
    }


    /**
     * Query Builder kalıtımı yapılıp Model'e aktarılıyor.
     * @return QueryBuilder
     */
    public static function registerQueryBoot()
    {
        return self::registerQueryGlobalScopes(new MySqlQueryBuilder);
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