<?php

/**
 * 博客控制器
 */
class BlogController extends Local\Controller\Base
{

	/**
	 * 初始化方法
	 *
	 */
	public function init()
	{
		$this->models['blogPostModel'] = new BlogpostModel();
	}

	/**
	 * 执行提交
	 */
	public function indexAction()
	{
		$id = (int) $this->getRequest()->getParam('id');

		//抓取图片地址
		//$url = EDUURL."/blog/{$blog}/{$id}.html";
		//获取博客内容
		$postInfo = $this->models['blogPostModel']->getOnePost($id);

		//获取上一篇，下一篇博客标题
		$backInfo = $this->models['blogPostModel']->getBackPost($id);
		$nextInfo = $this->models['blogPostModel']->getNextPost($id);

		//组合发布时间
		if (!empty($postInfo['post_date']))
		{
			$dateTime = explode(' ', $postInfo['post_date'])[0];
			$postInfo['post_date'] = explode('-', $dateTime);
		}


		//匹配博客中的图片地址
		$contents = $postInfo['post_content'];
		$match = "#src=\"([^\"|\']*)\"#";
		preg_match_all($match, $contents, $pics);
		if (!empty($pics[1]))
		{
			$images = array();
			foreach ($pics[1] as $image)
			{
				if (!strstr($image, 'http://edu.hxsd.com'))
				{
					$images[] = array(
						'url' => $image,
						'oldurl' => $image,
						'dirname' => str_replace('/blog/wp-content/uploads', '', pathinfo($image, PATHINFO_DIRNAME)),
						'basename' => $this->models['blogPostModel']->nameToChina($image),
						'type' => pathinfo($image, PATHINFO_EXTENSION),
					);
				}
				else
				{
					$images[] = array(
						'url' => str_replace('http://edu.hxsd.com', '', $image),
						'oldurl' => $image,
						'dirname' => str_replace('http://edu.hxsd.com/blog/wp-content/uploads', '', pathinfo($image, PATHINFO_DIRNAME)),
						'basename' => $this->models['blogPostModel']->nameToChina($image),
						'type' => pathinfo($image, PATHINFO_EXTENSION),
					);
				}
			}
		}

		//判断博客中是否含有图片
		if (!empty($images))
		{
			foreach ($images as $image)
			{
				//判断该图片是否已经存在于文件中，如果没有则生成图片
				$filename = PICDIR . 'blog' . $image['dirname'] . DS . $image['basename'];
				//$filename = iconv('UTF-8', 'GB2312', $filename);
				//判断操作系统转换图片名称编码
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
				{
					$filename = iconv('UTF-8', 'GB2312', $filename);
				}

				if (file_exists($filename) && (filemtime($filename) + 86400) < TIMENOW)
				{
					unlink($filename);
					//生成图片
					$this->models['blogPostModel']->getImgAction(EDUURL . $image['url'], $image['basename'], PICDIR . 'blog' . $image['dirname'] . '/');
				}
				elseif (!file_exists($filename))
				{
					//生成图片
					$this->models['blogPostModel']->getImgAction(EDUURL . $image['url'], $image['basename'], PICDIR . 'blog' . $image['dirname'] . '/');
				}

				//博客内容中图片地址替换
				$postInfo['post_content'] = str_replace($image['oldurl'], $this->models['blogPostModel']->getImgUrlAction($image['dirname'] . '/s_' . $image['basename']), $postInfo['post_content']);

				//生成缩略图
				$im = PICDIR . 'blog' . $image['dirname'] . '/' . $image['basename'];
				$this->models['blogPostModel']->resizeImage($im, 's_',266, 1);
			}
		}


		$postInfo['post_content'] = $this->wpautopAction($postInfo['post_content']);
		$this->_view->assign('postInfo', $postInfo);
		$this->_view->assign('postInfo', $postInfo);
		$this->_view->assign('backInfo', $backInfo);
		$this->_view->assign('nextInfo', $nextInfo);
		$this->_view->assign('id', $id);
	}

	public function wpautopAction($pee, $br = 1)
	{

		if (trim($pee) === '')
			return '';
		$pee = $pee . "\n"; // just to make things a little easier, pad the end
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
		// Space things out a little
		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
		$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
		if (strpos($pee, '<object') !== false)
		{
			$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
			$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
		}
		$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
		// make paragraphs, including one at the end
		$pees = preg_split('/\n\s*\n/', $pee, -1, 1);
		$pee = '';
		foreach ($pees as $tinkle)
			$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
		$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
		$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
		$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
		$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
		$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
		if ($br)
		{
			$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', create_function('$matches', 'return str_replace("\n", "<WPPreserveNewline />", $matches[0]);'), $pee);
			$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
			$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
		}
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
		$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
		if (strpos($pee, '<pre') !== false)
			$pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee);
		$pee = preg_replace("|\n</p>$|", '</p>', $pee);

		return $pee;
	}

}
