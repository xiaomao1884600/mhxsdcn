<?php

/**
 * 试听申请控制器
 */
class ListenOnlineController extends Local\Controller\Base
{



    /**
     * 初始化方法
     *
     */
    public function init()
    {
        $this->models['listenOnlineModel'] = new ListenOnlineModel();
    }

    /**
     * 执行提交
     */
    public function RunAuditionSubmitAction()
    {
        $data = $this->getRequest()->getPost('');
        $validate = empty($data['validate']) ? '' : strtolower(trim($data['validate']));
        unset($data['validate']);

        //15秒提交限制
        /* if (isset($_COOKIE['LISTENONLINELASTTIME']) && (time() - $_COOKIE['LISTENONLINELASTTIME']) < 15)
          {
          echo json_encode(array('erron' => 0, 'msg' => '您提交得太频繁了，休息一会吧！', 'id' => 'mobile'));
          exit();
          } */

        if (empty($data['name']))
        {
            echo json_encode(array('erron' => 2, 'msg' => '名字不能为空!', 'id' => 'mobile'));
            exit();
        }

        //如果有QQ提交,才验证
        if (!empty($data['qq']))
        {
            if ("" == $data['qq'] || 0 == $data['qq'])
            {
                echo json_encode(array('erron' => 3, 'msg' => '请输入您的qq！', 'id' => 'mobile'));
                exit();
            }
            if (!preg_match('/^\d{5,11}$/', $data['qq']))
            {
                echo json_encode(array('erron' => 3, 'msg' => '请重新输入QQ！', 'id' => 'mobile'));
                exit();
            }
        }

        if (empty($data['mobile']))
        {
            echo json_encode(array('erron' => 5, 'msg' => '请输入手机号', 'id' => 'mobile'));
            exit();
        }

        if (!preg_match('/^1[358][0-9]{9}$/', $data['mobile']))
        {
            echo json_encode(array('erron' => 5, 'msg' => '请正确输入手机号', 'id' => 'mobile'));
            exit();
        }

        if ($data['mobile'] == $data['qq'])
        {
            echo json_encode(array('erron' => 5, 'msg' => 'qq,电话不能重复', 'id' => 'mobile'));
            exit();
        }

        if (empty($data['course']) || 'undefined' == $data['course'] || '选择方向/专业' == $data['course'])
        {
            echo json_encode(array('erron' => 8, 'msg' => '选择试听专业', 'id' => 'mobile'));
            exit();
        }

        // 检查QQ号或手机当天出现过
        //$appeared = $this->models['listenOnlineModel']->getDayQqMobile($data['qq'], $data['mobile']);
        // 检查ip当天出现过多少次
        $appeared = $this->models['listenOnlineModel']->getIpNumMobile();

        //检查验证码
        if (3 <= $appeared)
        {
            if (empty($validate))
            {
                echo json_encode(array('erron' => 9, 'msg' => '请输入验证码', 'id' => 'mobile'));
                exit;
            }
            else
            {
                $svali = strtolower($this->models['listenOnlineModel']->GetCkVdValueMobile());
                if (empty($validate) || $validate != $svali)
                {
                    echo json_encode(array('erron' => 9, 'msg' => '验证码不正确！', 'id' => 'mobile'));
                    exit();
                }
            }
        }

        //保存数据
        //$data['course'] = implode(',', $course);
        $data['dateline'] = TIMENOW;
        $data['ipaddress'] = $_SERVER['REMOTE_ADDR'];

        if (!$this->models['listenOnlineModel']->setAuditionMobile($data))
        {
            echo json_encode(array('erron' => 10, 'msg' => '保存数据时失败，请检查你的输入资料是否存在问题！', 'id' => 'mobile'));
            exit();
        }

        //setcookie("LISTENONLINELASTTIME", time(), time() + 3600, "/");

        echo json_encode(array('status' => 1, 'msg' => 'success'));

        return FALSE;
    }

    /**
     * 验证手机或QQ是否重复出现
     */
    /*public function CheckAppearedAction()
    {
        $qq = $this->getRequest()->getPost('qq');
        $mobile = $this->getRequest()->getPost('mobile');
        if (empty($qq) && empty($mobile))
        {
            echo 0;
            exit;
        }
        if (empty($qq))
        {
            $qq = $mobile;
        }
        if (empty($mobile))
        {
            $mobile = $qq;
        }


        $appeared = $this->models['listenOnlineModel']->getDayQqMobile($qq, $mobile);

        if ($appeared)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }

        return FALSE;
    }*/
    
   //验证ip出现过几次
    public function CheckAppearedAction()
    {
        $appeared = $this->models['listenOnlineModel']->getIpNumMobile();

        if (3 <= $appeared)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }

        return FALSE;
    }

    /**
     * 验证码
     */
    public function IncludeAction()
    {
        $this->models['listenOnlineModel']->IncludeMobile();
        return FALSE;
    }

}
