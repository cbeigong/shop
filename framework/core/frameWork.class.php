<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/3 0003
 * Time: 下午 12:25
 */
// 核心启动类
class frameWork{
    // 让项目跑起来
    public static function run()
    {
         // echo "running ......";
        self::init();
//        var_dump(CUR_CONTROLLER_PATH);
        self::autoload();
        self::router();
    }
    // 定义初始化类方法
    public static function init() {
        define("DS", DIRECTORY_SEPARATOR);
        define("ROOT", getcwd() . DS);
        define("APP_PATH", ROOT . "application" . DS);
        define("FRAMEWORK_PATH", ROOT . "framework" . DS);
        define("PUBLIC_PATH", ROOT .  "public" . DS);
        define("MODEL_PATH", APP_PATH . "models" . DS);
        define("VIEW_PATH", APP_PATH . "views" . DS);
        define("CONTROLLER_PATH" , APP_PATH . "controllers" . DS);
        define("CONFIG_PATH", APP_PATH . "config" . DS);
        define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
        define("DB_PATH", FRAMEWORK_PATH . "database" . DS);
        define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);
        define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);

        // 前后台的视图和目录控制器定义 解析url中的参数， 可以确定具体的路径
        // _REQUEST[] 注意是，利用中括号，不是小括号
        define("PLATFORM", isset($_REQUEST["p"])? $_REQUEST["p"]:"home");
        // 默认是IndexController 此处规定控制器是大驼峰 注意要加ucfirst 
        define("CONTROLLER", isset($_REQUEST["c"]) ? ucfirst($_REQUEST["c"]) : "Index");
        // 默认indexAction 方法， 如果有传过来就是indexAction
        define("ACTION", isset($_REQUEST["a"]) ? $_REQUEST["a"] : "index");
        define("CUR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
        define("CUR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);

        // 载入基础控制器 
        require CORE_PATH . "Controller.class.php";
        require DB_PATH . "Mysql.class.php";
        // 有定义基础的类，或者基础函数 要记得加载进来，不然会报错
        require CORE_PATH . "Model.class.php";

        $GLOBALS["config"] = include  CONFIG_PATH . "config.php";
    }

    // 定义路由方法
    // 错误的路由方法
//    public static function router($classname) {
//        $controller_name = $classname . "Controller";
//        $action_name = $classname . "Action";
//
//        // 创建类的时候后面不要加括号
//        // 实例化 控制器 调用相应的方法
//        $controller = new $controller_name;
//        $controller->$action_name();
//    }
    public static function router(){
        // CONTROLLER 在init里面定义 默认是IndexController;
        $controller_name = CONTROLLER . "Controller";
        // Action 默认的方法是index 比如 indexAction
        $action_name = ACTION . "Action";

        // 实例化控制器 调用相应的方法
        // 当new $controller_name new不到的时候
        // 他回去调用spl_autoload_register() 通过这个函数
        // 去调用load方法 并把$controller_name作为load的参数传递进去
        $controller = new $controller_name;

        // 调用方法名的时候 要加上();
        $controller->$action_name();
        // var_dump($action_name);
    }

    // 注册加载方法
    public static function autoload() {
        // array  的构造器是通过array() 小括号里面传递参数进去的
        spl_autoload_register(array(__CLASS__, "load"));

    }

    //  加载方法 加载类的方法
    public static function load($classname) {
        if(substr($classname, -10) == "Controller") {
//            var_dump($classname);
            require CUR_CONTROLLER_PATH . "{$classname}.class.php";
        } elseif(substr($classname, -5) == "Model") {
            require MODEL_PATH . "{$classname}.class.php";
        } else {
            // 其他的情况暂且没有
        }
    }
}

