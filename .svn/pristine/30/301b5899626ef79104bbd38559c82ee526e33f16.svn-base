<?php
/**
 * 专题首页控制器
 *
 */

class TopicController extends Local\Controller\Base
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
     * ui2014专题
     *
     */
    public function UiOneFourAction()
    {
        $data = $this->getRequest()->getPost();
        
        if (empty($data['name']) || '名字不能为空!' == $data['name'])
        {
            echo json_encode(array('erron' => 2, 'msg' => '名字不能为空!', 'id' => 'mobile'));
            exit();
        }
        
        if (empty($data['mobile']) || '请输入手机号' == $data['mobile'])
        {
            echo json_encode(array('erron' => 3, 'msg' => '请输入手机号', 'id' => 'mobile'));
            exit();
        }

        if (!preg_match('/^1[358][0-9]{9}$/', $data['mobile']))
        {
            echo json_encode(array('erron' => 3, 'msg' => '请正确输入手机号', 'id' => 'mobile'));
            exit();
        }
        
        $data['dateline'] = TIMENOW;
        $data['ipaddress'] = $_SERVER['REMOTE_ADDR'];

        if (!$this->models['listenOnlineModel']->setAuditionMobile($data))
        {
            echo json_encode(array('erron' => 9, 'msg' => '保存数据时失败，请检查你的输入资料是否存在问题！', 'id' => 'mobile'));
            exit();
        }
        
        echo json_encode(array('status' => 1, 'msg' => 'success'));
        
        return FALSE;
    }
}


