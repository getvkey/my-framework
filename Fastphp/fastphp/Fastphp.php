<?php
namespace fastphp;

//框架根目录
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

/**
 * 框架类
 * Class Fastphp
 */
class Fastphp
{
    protected $config = null;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 运行程序
     */
    public function run()
    {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setRePosting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->setDbConfig();
        $this->route();
    }

    /**
     * 路由处理
     */
    public function route()
    {
        $controllerName = $this->config['defaultController'];
        $actionName = $this->config['defaultAction'];
        $param = array();

        $url = $_SERVER['REQUEST_URI'];

        //查找？在url中第一次出现的位置
        $position = strpos($url, '?');

        $url = $position === false ? $url : substr($url, 0, $position);

        // 使得可以这样访问 index.php/{controller}/{action}
        $position = strpos($url, 'index.php');
        if ($position !== false) {
            $url = substr($url, $position + strlen('index.php'));
        }

        // 删除前后的“/”
        $url = trim($url, '/');

        if ($url) {
            // 使用“/”分隔字符串，保存在数组中
            $urlArray = explode('/', $url);

            // 删除空的数组元素
            $urlArray = array_filter($urlArray);

            // 获取控制器名 首字母大写
            $controllerName = ucfirst($urlArray[0]);

            // 移除第一个元素，获取动作名
            array_shift($urlArray);
            $actionName = $urlArray ? $urlArray[0] : $actionName;

            // 获取URL参数
            array_shift($urlArray);
            $param = $urlArray ? $urlArray : array();
        }

        // 判断控制器和操作是否存在
        $controller = 'app\\controllers\\'. $controllerName . 'Controller';
        if (!class_exists($controller)) {
            exit($controller . '控制器不存在');
        }
        if (!method_exists($controller, $actionName)) {
            exit($actionName . '方法不存在');
        }

        // 如果控制器和方法存在，则实例化控制器，因为控制器对象里面还会用到控制器名和方法名，所以实例化传过去
        $dispatch = new $controller($controllerName, $actionName);

        // $dispatch保存控制器实例化后的对象，我们就可以调用它的方法
        // 也可以向方法传入参数一下等同于：$dispatch->$actionName($param)
        call_user_func_array([$dispatch, $actionName], $param);

    }

    /**
     * 检查开发环境
     */
    public function setRePosting(){
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errorss', 'Off');
            ini_set('log_errors', 'On');
        }
    }

    /**
     * 删除敏感字符
     *
     * @param $value
     * @return array|string
     */
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripcslashes($value);

        return $value;
    }

    /**
     * 检查敏感字符并删除
     */
    public function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    /**
     * 检测自定义全局变量并移除。因为 register_globals 已经弃用，
     * 如果已经弃用的 register_globals 指令被设置为 on，形式存在，这样写是不好的实现，会影响代码中的其他变量。
     * 相关信息，参考: http://php.net/manual/zh/faq.using.php#faq.register-globals
     */
    public function unregisterGlobals()
    {
        if (ini_get('register_globals')) {
            $array = ['_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES'];
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    /**
     * 配置数据库信息
     *
     */
    public function setDbConfig()
    {
        if ($this->config['db']) {
            define('DB_HOST', $this->config['db']['host']);
            define('DB_NAME', $this->config['db']['dbname']);
            define('DB_USER', $this->config['db']['username']);
            define('DB_PASS', $this->config['db']['password']);
        }
    }

    /**
     * 自动加载类
     *
     * @param $className
     */
    public function loadClass($className)
    {
        $classMap = $this->classMap();

        if (isset($classMap[$className])) {
            // 包含内核文件
            $file = $classMap[$className];
        } elseif (strpos($className, '\\') !== false) {
            // 包含应用（application目录）文件
            $file = APP_PATH . str_replace('\\', '/', $className) . '.php';
            if (!is_file($file)) {
                return;
            }
        } else {
            return;
        }

        include $file;

        // 这里可以加入判断，如果名为$className的类、接口或者性状不存在，则在调试模式下抛出错误
    }

    /**
     * 内核文件命名空间映射关系
     *
     */
    protected function classMap()
    {
        return [
            'firstphp\base\Controller' => CORE_PATH . '/base/Controller.php',
            'firstphp\base\Model' => CORE_PATH . '/base/Model.php',
            'firstphp\base\View' => CORE_PATH . '/base/View.php',
            'firstphp\db\Db' => CORE_PATH . '/db/Db.php',
            'firstphp\db\Sql' => CORE_PATH . '/db/Sql.php',
        ];
    }

    public function json_response($message = null, $data = [], $code = 200)
    {
        echo json_encode(array(
            'status' => $code,
            'message' => $message,
            'data' => $data
        ));
    }
}