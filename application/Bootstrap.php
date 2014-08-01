<?php

/**
 * 引导文件
 *
 * @author $Author: 5590548@qq.com $
 *
 */
class Bootstrap extends Yaf\Bootstrap_Abstract
{

	private $_config;

	/**
	 * 初始化配置项
	 *
	 */
	public function _initConfig()
	{
		$this->_config = Yaf\Application::app()->getConfig();
		Yaf\Registry::set('config', $this->_config);
	}

	/**
	 * 初始化命名空间，以 Zend, Local, Third 开头的类为本地类
	 *
	 */
	public function _initNamespaces()
	{
		Yaf\Loader::getInstance()->registerLocalNameSpace(array(
			'Zend',
			'Local',
			'Third'
		));
	}

	/**
	 * 注册常量
	 *
	 *
	 */
	public function _initConstant()
	{
		// 项目URL
		define('SYSTEMURL', $this->_config->application->baseUrl);
		
		//项目目录
		define('ROOT', $this->_config->application->url);
		
		// 管理后台URL
		define('ADMINURL', ROOT . '/admin');
		
		// 缓存文件保存路径
		define('CACHE_PATH', $this->_config->cache->path);
		
		//学院网URL
		define('EDUURL', $this->_config->application->eduUrl);

		//图片服务器地址
		define('PICURL',$this->_config->application->picUrl);

		//图片存储路径
		define('PICDIR',$this->_config->application->picDir);
		//上传文件格式
		define('PICTYPE', $this->_config->application->picType);
		//文件存储路径
		define('CLASSMOBILEPATH', $this->_config->classesmobile->attachment);

		// 默认分页数
		define('PERPAGE', $this->_config->pages->perpage);

		// 支付成功
		define('ALIPAY_SUCCESS', $this->_config->alipay->success);
		// 支付失败
		define('ALIPAY_FAIL', $this->_config->alipay->fail);

		//默认Memcache过期时间
		define('EXPIRE', $this->_config->mem->expire);

		//火星看点默认显示分页数
		define('ASPECTNUM', $this->_config->aspect->num);

		//设置表前缀
		define('PREFIX', $this->_config->database->params->prefix);
		
		// Cookies 超时时间
		define('COOKIE_TIMEOUT', (TIMENOW + $this->_config->cookies->timeout));
		
		//用户组
		if ($this->_config->users->groupid)
		{
			foreach ($this->_config->users->groupid as $key => $value)
			{
				define('USERGROUP_ID_' . strtoupper($key), $value);
			}
		}
		// 用户密码长度限制
		define('USER_PASSWORD_MIN', $this->_config->users->default->minpassword);
		define('USER_PASSWORD_MAX', $this->_config->users->default->maxpassword);
		//邮箱规则
		define('USER_EMAILREGEX', $this->_config->users->default->emailRegex);
	}

	/**
	 * 自定义路由
	 *
	 */
	public function _initRoute(Yaf\Dispatcher $dispatcher)
	{
		$router = $dispatcher::getInstance()->getRouter();
		$routes = new Yaf\Config\Ini(APP_PATH . DS . 'conf' . DS . 'routes.ini', 'routes');
		$router->addConfig($routes->routes);
		//\Local\Util\Debug::x(Yaf\Registry::get("config")->routes);
		//$router->addConfig(Yaf\Registry::get("config")->routes);
	}

	/**
	 * 连接数据库，设置数据库适配器
	 *
	 */
	public function _initDefaultDbAdapter()
	{
		$db = new Zend\Db\Adapter\Adapter(
				$this->_config->database->params->toArray()
		);

		Yaf\Registry::set('db', $db);
	}

	/**
	 * 连接Memcache
	 *
	 */
	public function _initMem()
	{
		$memcache = new Local\Util\Mem(
				$this->_config->mem->toArray());
		Yaf\Registry::set('memcache', $memcache);
	}

	/**
	 * 初始化插件
	 *
	 * @param Yaf_Dispatcher $dispatcher
	 */
	public function _initPlugin(Yaf\Dispatcher $dispatcher)
	{
		$site = new SitePlugin();
		$dispatcher->registerPlugin($site);

		//$divice = new DevicePlugin();
		//$dispatcher->registerPlugin($divice);
	}
	
	/** 
	 * 初始化系统设置
	 * 
	 * */
	public function _initSetting()
	{
		$settings = Local\Util\Cache::getCache(CACHE_PATH . '/setting.json');
		$setting = array();
		if (!empty($settings))
		{
			foreach ($settings as $key => $value)
			{
				$setting[$value['title']] = $value['value'];
			}
		}
		
		Yaf\Registry::set('setting', $setting);
		unset($settings, $setting);
	}
	
	/** 初始化加载文件上传类 */
	public function _initUploadFile()
	{
		//加载functions文件
		include ROOT_PATH . '/application/library/Local/Functions/functions.php';
		include ROOT_PATH . '/application/library/Local/Util/UploadFile.php';
		$upload = new UploadFile();
		Yaf\Registry::set('upload', $upload);
	}
}