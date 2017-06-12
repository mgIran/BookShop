<?php
class ApiController extends ApiBaseController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
//            'RestAccessControl'
        );
    }

    public function actionList()
    {
        $list = [1];
        if($list){
            $this->_sendResponse(200, CJSON::encode([
                'status' => true,
                'list' => $list
            ]), 'application/json');
        }else
            $this->_sendResponse(200, CJSON::encode([
                'status' => false,
                'message' => 'اطلاعاتی برای دریافت موجود نیست.'
            ]), 'application/json');
    }

    public function actionTest()
    {
        return true;
    }
}