<?php

/**
 * 模型基类
 *
 * @author $Author: 5590548@qq.com $
 *
 */

namespace Local\Db;

class Base
{

	// 数据库对象
	protected $db;
	// 表名
	protected $table;

	/**
	 * 构造函数
	 *
	 */
	public function __construct()
	{
		$this->db = \Yaf\Registry::get('db');
	}

	/**
	 * 对表名或字段加上相应的引用符
	 *
	 * @param string $str
	 * @return string
	 */
	protected function q($str)
	{
		return $this->db->platform->quoteIdentifier($str);
	}

	/**
	 *
	 *
	 * @param string $str
	 * @return string
	 */
	protected function e($str)
	{
		return $this->db->platform->quoteValue(htmlspecialchars($str));
	}

	/**
	 * 返回查询
	 *
	 * @param string $sql
	 * @return object
	 *
	 */
	protected function queryResult($sql)
	{
		$query = $this->db->query($sql);
		$result = $query->execute();
		return $result;
	}

	/**
	 * 查询多条数据
	 *
	 * @param string $sql
	 * @return array
	 *
	 */
	public function queryArray($sql)
	{
		$result = $this->queryResult($sql);

		$data = array();
		while ($row = $result->current())
		{
			$data[] = $row;
		}
		unset($result, $row);
		return $data;
	}

	/**
	 * 查询单条数据
	 *
	 * @param string $sql
	 * @return array
	 *
	 */
	public function queryFirst($sql)
	{
		$result = $this->queryResult($sql);
		$row = $result->current();
		return $row;
	}

	/**
	 * 查询单个字段
	 *
	 * @param string $sql
	 * @return string
	 */
	public function queryOne($sql)
	{
		$result = $this->queryFirst($sql);
		return current($result);
	}

	/**
	 * 查询，用于 Insert/Updata/Delete
	 *
	 * @param string $sql
	 *
	 */
	public function queryWrite($sql)
	{
		$query = $this->db->query($sql);
		$query->execute();
	}

	/**
	 * 保存/更新数据
	 *
	 * @param array $data
	 * @return
	 *
	 */
	public function saveData($data)
	{
		if (empty($data))
		{
			return;
		}

		$db = & $this->db;
		$sql = array();
		$id = $data[$this->table . 'id'];
		unset($data[$this->table . 'id']);

		foreach ($data as $key => $value)
		{
			$sql[] = $this->q($key) . ' = ' . $this->e($value);
		}

		if (empty($id))
		{
			$query = $db->query("
				INSERT INTO " . $this->q(PREFIX . $this->table) . " SET
				" . implode(',', $sql) . "
			", $db::QUERY_MODE_EXECUTE);
		}
		else
		{
			$query = $db->query("
				UPDATE " . $this->q(PREFIX . $this->table) . " SET
				" . implode(',', $sql) . "
				WHERE {$this->table}id = {$id}
			", $db::QUERY_MODE_EXECUTE);
		}

		return $query;
	}

	/**
	 * insert 语句
	 * 返回刚插入的那条记录的ID
	 */
	public function insertOne($sql)
	{
		$query = $this->db->query($sql);
		$query->execute();
		return $this->db->getDriver()->getLastGeneratedValue();
	}

	/** 添加数据 */
	public function insertData($data)
	{
		if (empty($data))
		{
			return ;
		}
		$newData = array();
		foreach ($data as $k => $v)
		{
			$newData[] = "`$k`" . " = "."'$v'";
		}
		//添加数据sql
		$sql = "INSERT INTO " . ($this->q(PREFIX . $this->table)) . " SET
			" . (implode(',', $newData)) . "
		";
		
		return $this->insertOne($sql);
	}
	/**
	 * 分页类
	 * @param type $currentPage
	 * @param type $totalPage
	 * @param type $url
	 * @param type $half
	 * @return string
	 */
	public function pageNav($currentPage, $totalPage, $url, $half = 3)
	{
		$html = '';
		if ($totalPage > 1)
		{
			if ($currentPage > $totalPage)
			{
				$currentPage = $totalPage;
			}

			$html .= '<ul class="pager-animation">';
			//$html .= "<li" . ((1 == $currentPage) ? ' class="pager-first first"' : '') . "><a class=\"active\" " . ((1 != $currentPage) ? "href=\"{$url}/page/1\"" : '') . ">&laquo; 首页</a></li>";
			$upPage = $currentPage == 1 ? '' : $currentPage - 1;
			$html .= "<li" . ((1 == $currentPage) ? ' class="pager-previous"' : '') . "><a class=\"active\" " . ((1 != $currentPage) ? "href=\"{$url}/page/{$upPage}\"" : '') . ">‹ 上一页</a></li>";

			/*			 * $begin = 1;
			  if ($currentPage > ($half + 1))
			  {
			  $begin = $currentPage - $half;
			  }
			  $end = $begin + $half * 2;
			  if ($end > $totalPage)
			  {
			  $end = $totalPage;
			  $begin = $end - $half * 2;
			  }
			  if ($begin < 1)
			  {
			  $begin = 1;
			  } */

			/* for ($i = $begin; $i <= $end; $i++)
			  {
			  if ($i == $currentPage)
			  {
			  $html .= "<li class=\"pager-item pager-current\"><a class=\"active\" href=\"\">{$i}</a></li>";
			  }
			  else
			  {
			  $html .= "<li class=\"pager-item\" ><a class=\"active\" href=\"{$url}/page/{$i}\">{$i}</a></li>";
			  }
			  } */
			$downPage = $currentPage >= $totalPage ? $currentPage : $currentPage + 1;
			$html .= "<li" . (($totalPage == $currentPage) ? ' class="pager-previous"' : '') . "><a class=\"active\" " . (($totalPage != $currentPage) ? "href=\"{$url}/page/{$downPage}\"" : '') . ">下一页 ﹥</a></li>";
			// $html .= "<li" . (($totalPage == $currentPage) ? ' class="pager-first first"' : '') . "><a class=\"active\" " . (($totalPage != $currentPage) ? "href=\"{$url}/page/{$totalPage}\"" : '') . ">尾页 &raquo;</a></li>";
			$html .= '</ul>';
		}
		return $html;
	}

	/*
	 * $url 远程图片的完整地址
	 * $filename 本地文件名 为空时以时间命名
	 * return filename
	 */

	public function getImgAction($url, $filename = '', $savefile = 'aa/')
	{
		$imgArr = array('gif', 'bmp', 'png', 'ico', 'jpg', 'jepg');

		if (!$url)
			return false;

		if (!$filename)
		{
			$ext = strtolower(end(explode('.', $url)));
			if (!in_array($ext, $imgArr))
				return false;
			$filename = date("dMYHis") . '.' . $ext;
		}

		if (!is_dir($savefile))
		{
			mkdir($savefile, 0777, true);
		}
		if (!is_readable($savefile))
		{
			chmod($savefile, 0777);
		}
		//$filename = iconv("UTF-8", "GBK", $filename);
		//判断操作系统转换图片名称编码
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
		{
			$filename = iconv("UTF-8", "GBK", $filename);
		}
		$filename = $savefile . $filename;

		ob_start();
		readfile($url);
		$img = ob_get_contents();
		ob_end_clean();
		$size = strlen($img);

		$fp2 = @fopen($filename, "a");
		fwrite($fp2, $img);
		fclose($fp2);

		return $filename;
	}

	/**
	 * 图片缩放
	 */
	function resizeImage($image, $prefix = '', $width = 266, $compression = 0)
	{
		//判断操作系统转换图片名称编码
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
		{
			$image = iconv('utf-8', 'gbk', $image);
		}
		//获取图片相关信息
		$imgInfo = getimagesize($image);
		$imgInfo['width'] = $imgInfo[0];
		$imgInfo['height'] = $imgInfo[1];
		$width = $imgInfo['width'] < $width ? $imgInfo['width'] : $width;

		if (!empty($imgInfo['width']) && !empty($imgInfo['height']))
		{

			switch ($imgInfo['mime'])
			{
				case 'image/jpeg':
					$imgRes = imagecreatefromjpeg($image);
					break;
				case 'image/gif':
					$imgRes = imagecreatefromgif($image);
					break;
				case 'image/png':
					$imgRes = imagecreatefrompng($image);
					break;
				case 'image/bmp':
					$imgRes = imagecreatefromwbmp($image);
					break;
			}

			if ($imgRes)
			{
				$proportion = $width / $imgInfo['width'];
				$height = $imgInfo['height'] * $proportion;

				$white = imagecreatetruecolor($width, $height);

				//缩小图片
				imagecopyresampled($white, $imgRes, 0, 0, 0, 0, $width, $height, $imgInfo['width'], $imgInfo['height']);

				$imgName = $prefix ? $prefix . $this->nameToChina($image) : $this->nameToChina($image);
				$imageName = dirname($image) . DS . $imgName;
				if (file_exists($imageName))
				{
					unlink($imageName);
				}

				if (!$compression)
				{
					imagepng($white, $imageName);
				}
				else
				{
					imagejpeg($white, $imageName);
				}



				//销毁资源
				imagedestroy($white);
				imagedestroy($imgRes);
			}
		}
	}

	/*
	 * 获取路径中中文文件名
	 */

	public function nameToChina($name)
	{
		return ltrim(substr($name, strrpos($name, '/')), "/");
	}

	/*
	 * 获取图片地址
	 */

	public function getImgUrlAction($file, $dir = 'blog')
	{
		if ($file)
		{
			return 'http://img' . rand(0, 9) . PICURL .'/edu/mhxsd/' . $dir . DS . $file;
		}
	}

}
