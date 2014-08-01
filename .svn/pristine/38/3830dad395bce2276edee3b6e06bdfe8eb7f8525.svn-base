<?php

/**
 * 首页控制器
 *
 * @author $Author: 5590548@qq.com $
 *
 */
class AboutTeacherController extends Local\Controller\Base
{

    /**
     * 初始化方法
     *
     */
    public function init()
    {
        $this->models = array(
            'teachersModel' => new TeachersModel(),
            'reflectionsModel' => new ReflectionsModel(),
            'classModel' => new ClassModel()
        );
    }

    /**
     * 首页
     *
     */
    public function indexAction()
    {
        $page = $this->getRequest()->getParam('page');
        $page = max(1, $page);

        //获取教师数量
        $treachNum = $this->models['teachersModel']->getTeachersNum();
        //总页数
        $pageTotal = ceil($treachNum / 8);
        //查询偏移量
        $page = $page > $pageTotal ? $pageTotal : $page;
        $offset = ($page - 1) * 8;

        //获取教师数据
        $data = $this->models['teachersModel']->getTeachers($offset);

        $images = array();
        foreach($data as $value)
        {
            $images[] = array(
                'url' => $value['photo'],
                'dirname' => str_replace('/uploads', '', pathinfo($value['photo'], PATHINFO_DIRNAME)),
                'basename' => $this->models['teachersModel']->nameToChina($value['photo']),
                'type' => pathinfo($value['photo'], PATHINFO_EXTENSION),
            );
        }

        if(!empty($images))
        {
            foreach ($images as $key => $image)
            {
                //判断该图片是否已经存在于文件中，如果没有则生成图片
                $filename = PICDIR . DS . 'aboutteacher' . $image['dirname'] . DS . $image['basename'];
                //$filename = iconv('UTF-8', 'GB2312', $filename);

                //判断操作系统转换图片名称编码
                if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                {
                    $filename = iconv('UTF-8', 'GB2312', $filename);
                }

                if (!file_exists($filename))
                {
                    $this->models['teachersModel']->getImgAction(EDUURL . $image['url'], $image['basename'], PICDIR . 'aboutteacher' . $image['dirname'] . DS);
                }

                $data[$key]['photo'] = str_replace($image['url'],$this->models['teachersModel']->getImgUrlAction($image['dirname'] . '/s_' . $image['basename'],'aboutteacher'), $data[$key]['photo']);

                //生成缩略图
                $im = PICDIR . DS . 'aboutteacher' . $image['dirname'] . '/' . $image['basename'];
                $this->models['teachersModel']->resizeImage($im, 's_',125,1);
            }
        }

        $this->getView()->assign('data', $data);
        $this->getview()->assign('pageNav', $this->models['teachersModel']->pageNav($page, $pageTotal, '/aboutteacher/index', 1));
    }

    /**
     * 联系我们
     */
    public function abouttelAction()
    {

    }

    /**
     * 师资力量
     */
    public function aboutTeacherAction()
    {
        $page = $this->getRequest()->getParam('page');
        $page = max(1, $page);

        //获取教师数量
        $treachNum = $this->models['teachersModel']->getTeachersNum();
        //总页数
        $pageTotal = ceil($treachNum / 8);
        //查询偏移量
        $page = $page > $pageTotal ? $pageTotal : $page;
        $offset = ($page - 1) * 8;

        //获取教师数据
        $data = $this->models['teachersModel']->getTeachers($offset);

        $this->getView()->assign('data', $data);
        $this->getview()->assign('pageNav', $this->models['teachersModel']->pageNav($page, $pageTotal, '/aboutus/aboutteacher', 1));
    }

    /**
     * 学员感言
     */
    public function stusayAction()
    {
        $page = $this->getRequest()->getParam('page');
        $page = max(1, $page);

        //获取学生数量
        $studentReflectionsNum = $this->models['reflectionsModel']->getStudentReflectionsNum();
        //总页数
        $pageTotal = ceil($studentReflectionsNum / 8);
        //查询偏移量
        $page = $page > $pageTotal ? $pageTotal : $page;
        $offset = ($page - 1) * 8;

        //获取教师数据
        $data = $this->models['reflectionsModel']->getStudentReflections($offset);
        $classses = $this->models['classModel']->getAllClasses();

        foreach ($data as &$value)
        {
            foreach ($classses as $val)
            {
                if ($value['classid'] == $val['id'])
                {
                    $value['classname'] = $val['name'];
                }
            }
        }

        $this->getView()->assign('classes', $classses);
        $this->getView()->assign('data', $data);
        $this->getview()->assign('pageNav', $this->models['reflectionsModel']->pageNav($page, $pageTotal, '/aboutus/stusay', 1));
    }

}
