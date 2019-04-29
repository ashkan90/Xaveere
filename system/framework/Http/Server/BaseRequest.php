<?php


namespace Xaveere\framework\Http\Server;


class BaseRequest
{

    const CLIENT_IP = 'client_ip';
    const CLIENT_HOST = 'client_host';


    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';


    /**
     * Oluşturulacak isteğin gövdesi. ($_POST)
     * @var
     */
    public $request;

    /**
     * Oluşturulacak isteğin parametreleri. ($_GET)
     * @var
     */
    public $query;

    /**
     * Server bilgileri ve işleme alınacak parçalar. ($_SERVER)
     * @var
     */
    public $server;

    /**
     * @var
     */
    public $attributes;

    /**
     * @var
     */
    protected $requestUri;

    /**
     * @var
     */
    protected $baseUrl;

    /**
     * @var
     */
    protected $basePath;

    /**
     * @var
     */
    protected $method;

    /**
     * Redirect URL
     * @var
     */
    protected $to;


    public function __construct(array $query = array(), array $request = array(), array &$server = array())
    {
        $this->initialize(
            $query,
            $request,
            $server
            );

        $this->serializeForDefaults();
        return $this;
    }

    public function initialize(array $query, array $request, array &$server, $content = null)
    {
        $this->request = $request;
        $this->query = $query;
        $this->server = $server;

        $this->basePath = null;
        $this->baseUrl = null;
        $this->requestUri = null;
        $this->method = null;
    }

    public static function createRequestFromDefault()
    {
        return (object) new static($_GET, $_POST, $_SERVER);
    }

    public function serializeForDefaults()
    {
        if ($this->checkForType($this->server)) {
            $this->method     = $this->server['REQUEST_METHOD'];
            $this->requestUri = $this->server['REQUEST_URI'] ;
            $this->query      = $this->server['QUERY_STRING'];
            $this->to         = $this->server['REDIRECT_URL'];
            $this->baseUrl    = $this->urlFull();
            $this->basePath   = $this->url();

            return $this;
        }

        return false;
    }

    function parseQuery()
    {
        //$new_query = explode
    }

    public function urlFull()
    {
        return sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS'])
                    && $_SERVER['HTTPS'] != 'off'
                        ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
        );
    }

    function url()
    {
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }

    /**
     * $_GET, $_POST içerisinde gezinen tüm input ları getiriyor.
     * @return object
     */
    public function all()
    {
        return $this->checkForType($this->request)
            ? (object) $this->request
            : (object) null;
    }

    /**
     * İstenilen $key in eğer var ise keyi ve değeri ile birlikte döndürüyor.
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function get($key)
    {
        if ($this->checkForType($this->request)) {
            if ($this->has($key))
                return [$key => $this->request[$key]];
        }
    }


    /**
     * Request'in içinde, istenen $key'i kontrol eder.
     * @param $key
     * @return bool
     * @throws \Exception
     */
    public function has($key)
    {
        if ($this->checkForType($this->request)) {
            if ($this->request[$key])
                return true;
            return false;
        }

        throw new \Exception("Request is not valid type");
    }

    /**
     * Objelerin içerisinde konumlanacak olan Array in varlığını kontrol ediyor.
     * @param $will_be_checked
     * @return bool
     */
    private function checkForType($will_be_checked)
    {
        if (is_array($will_be_checked))
            return true;
        return false;
    }

    public static function __callStatic($method, $arguments)
    {
        return (new static)->{$method}($arguments);
    }

}