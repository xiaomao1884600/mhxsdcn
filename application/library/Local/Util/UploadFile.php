<?php
class UploadFile
{

	//用户上传的文件
	var $user_post_file = array();
	//存放用户上传文件的路径
	var $save_file_path;
	//文件最大尺寸
	var $max_file_size;
	//默认允许用户上传的文件类型
	var $allow_type = array(
		'gif',
		'jpg',
		'png',
		'zip',
		'rar',
		'txt',
		'doc',
		'pdf'
	);
	//最终保存的文件名
	var $final_file_path;
	// 文件新名称
	var $new_name;
	//返回一组有用信息，用于提示用户。
	var $save_info = array();
	// 错误号
	var $error_no = 0;
	/** 构造函数 */
	function __construct()
	{
		
		
	}
	/**
	 * 构造函数，用与初始化相关信息，用户待上传文件、存储路径等
	 *
	 * @param Array $file  用户上传的文件
	 * @param String $path  存储用户上传文件的路径
	 * @param String $newname 文件名称
	 * @param Integer $size 允许用户上传文件的大小(字节)
	 * @param Array $type   此数组中存放允计用户上传的文件类型
	 */
	function UploadFiles($file, $path, $newname = '', $size = 2097152, $type = array())
	{
		$this->user_post_file = $file;
		$this->save_file_path = $path;
		$this->new_name = $newname ? $newname : $this->user_post_file['name'];

		//如果用户不填写文件大小，则默认为2M.
		$this->max_file_size = $size;
		if (!empty($type))
		{
			$this->allow_type = $type;
		}
	}

	/**
	 * 存储用户上传文件，检验合法性通过后，存储至指定位置。
	 * @access public
	 * @return int    值为0时上传失败，非0表示上传成功的个数。
	 */
	function upload()
	{
		//如果当前文件上传功能，则执行下一步。
		if ($this->user_post_file['error'] == 0)
		{
			//取当前文件名、临时文件名、大小、扩展名，后面将用到。
			$tmpname = $this->user_post_file['tmp_name'];
			$size = $this->user_post_file['size'];
			$mime_type = $this->user_post_file['type'];
			$type = $this->getFileExt($this->user_post_file['name']);

			//检测当前上传文件大小是否合法。
			if (!$this->checkSize($size))
			{
				$this->error_no = 1;
				return $this->error_no;
			}

			//检测当前上传文件扩展名是否合法。
			if (!$this->checkType($type))
			{
				$this->error_no = 2;
				return $this->error_no;
			}

			//检测当前上传文件是否非法提交。
			if (!is_uploaded_file($tmpname))
			{
				$this->error_no = 3;
				return $this->error_no;
			}

			/* 创建文件夹 */
			if (!is_dir($this->save_file_path))
			{
				@mkdir($this->save_file_path, 0777, true);
				// 创建一个空首页
				file_put_contents($this->save_file_path . '/index.html', '');
			}

			$this->final_file_path = $this->save_file_path . $this->new_name;

			if (!move_uploaded_file($tmpname, $this->final_file_path))
			{
				@unlink($tmpname);
				$this->error_no = 4;
				return $this->error_no;
			}

			//存储当前文件的有关信息，以便其它程序调用。
			$this->save_info = array(
				"name" => $this->new_name,
				"type" => $type,
				"mime_type" => $mime_type,
				"size" => $size,
				"saveas" => $saveas,
				"path" => $this->final_file_path,
			);
		}

		//上传成功
		return $this->error_no;
	}

	/**
	 * 返回一些有用的信息，以便用于其它地方。
	 * @access public
	 * @return Array 返回最终保存的路径
	 */
	function getSaveInfo()
	{
		return $this->save_info;
	}

	/**
	 * 检测用户提交文件大小是否合法
	 * @param Integer $size 用户上传文件的大小
	 * @access private
	 * @return boolean 如果为true说明大小合法，反之不合法
	 */
	function checkSize($size)
	{
		if ($size > $this->max_file_size)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * 检测用户提交文件类型是否合法
	 * @access private
	 * @return boolean 如果为true说明类型合法，反之不合法
	 */
	function checkType($extension)
	{
		foreach ($this->allow_type as $type)
		{
			if (strcasecmp($extension, $type) == 0)
				return true;
		}
		return false;
	}

	/**
	 * 显示出错信息
	 * @param  $msg    要显示的出错信息
	 * @access private
	 */
	function halt($msg)
	{
		printf("<b><UploadFile Error:></b> %s <br>\n", $msg);
	}

	/**
	 * 取文件扩展名
	 * @param  String $filename 给定要取扩展名的文件
	 * @access private
	 * @return String      返回给定文件扩展名
	 */
	function getFileExt($filename)
	{
		$stuff = pathinfo($filename);
		return $stuff['extension'];
	}

	/**
	 * 取给定文件文件名，不包括扩展名。
	 * eg: getBaseName("j:/hexuzhong.jpg"); //返回 hexuzhong
	 *
	 * @param String $filename 给定要取文件名的文件
	 * @access private
	 * @return String 返回文件名
	 */
	function getBaseName($filename, $type)
	{
		$basename = basename($filename, $type);
		return $basename;
	}

}

?>
