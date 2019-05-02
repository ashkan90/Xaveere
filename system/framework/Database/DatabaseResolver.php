<?php


namespace Xaveere\framework\Database;


use Xaveere\framework\Helpers\Str;
use Xaveere\framework\Query\MySqlQueryBuilder;
use Xaveere\framework\Query\QueryBuilder;

trait DatabaseResolver
{

    /**
     * Sınıfın kalıtımını yapacak yer.
     * @var DatabaseResolver|null
     */
    private static $instance;

    protected $table;

    /**
     * Çağırılan sınıfın kalıtımını alıyor, (Model) sınıfı
     * DatabaseResolver constructor.
     */
    public function __construct()
    {
        // HATA ÇIKABİLİR.
        self::$instance = null;
        if (is_null(self::$instance))
        {
            $class = get_called_class();
            self::$instance = new $class;
        }

        return self::$instance = $this;
    }


    /**
     * Topluluğu bootstrap yapmak için kullanılacak.
     */
    public function boot()
    {
        return $this->table ?? $this->table = self::ResolveTable();
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
        $table_name = Str::getNthIndexForExplodedString(Str::lower(get_called_class()), '\\', 2);

        return $table_name;
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