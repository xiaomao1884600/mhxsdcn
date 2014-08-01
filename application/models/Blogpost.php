<?php

/**
 * 首页博客文章模型
 */
class BlogPostModel extends Local\Db\Base
{

	protected $table = 'blog_posts';

	/** *
	 * $limit 数量
	 * 按条件查询博客
	 */

	public function getBlogPost($limit)
	{
		$sql = "
			SELECT
			*
			FROM " . $this->table . "
			WHERE post_status='publish'
			ORDER BY post_modified desc
			LIMIT 0,{$limit}
		";
		return $this->queryArray($sql);
	}

	public function getOnePost($id)
	{
		$sql = "
			SELECT
			post_title,post_date,post_content
			from " . $this->table . "
			WHERE id={$id} AND post_status ='publish'
		";
		return $this->queryFirst($sql);
	}

    public function getBackPost($id)
	{
		 $sql = "
			SELECT
			id,post_title
			from " . $this->table . "
			WHERE id = (
                SELECT MAX(id) FROM " . $this->table . " WHERE id < {$id} AND post_date > 20110000000000 AND post_status ='publish'
            )
		";
		return $this->queryFirst($sql);
	}

    public function getNextPost($id)
	{
		$sql = "
			SELECT
			id,post_title
			from " . $this->table . "
			WHERE id = (
                SELECT MIN(id) FROM " . $this->table . " WHERE id > {$id} AND post_status ='publish'
            )
		";
		return $this->queryFirst($sql);
	}

}