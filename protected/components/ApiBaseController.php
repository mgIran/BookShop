<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 *
 * @property [] $loginArray
 */
class ApiBaseController extends CController
{
    protected function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $content_type);

        // pages with body are easy
        if($body != ''){
            // send the body
            echo $body;
        } // we need to create the body if none is passed
        else{
            // create some body messages
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch($status){
                case 401:
                    $message = 'You must send token for authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on
            // (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '')?$_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT']:$_SERVER['SERVER_SIGNATURE'];

            // this should be templated in a real-world solution
            $body = '
				<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
				<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
				</head>
				<body>
					<h1>' . $this->_getStatusCodeMessage($status) . '</h1>
					<p>' . $message . '</p>
					<hr />
					<address>' . $signature . '</address>
				</body>
				</html>';

            echo $body;
        }
        Yii::app()->end();
    }

    protected function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status]))?$codes[$status]:'';
    }

    /**
     * @return bool
     */
    protected function _checkAuth()
    {
        if(!isset(getallheaders()['Authorization'])){
            $this->_sendResponse(401);
        }
        $authorization = getallheaders()['Authorization'];
        $token = str_ireplace('Token ', '', $authorization);
        if(!$token)
            $this->_sendResponse(401, 'Error: Authorization code was not set or invalid.');
        // Find the api token

//        $this->_headers = array(
//            "Authorization: Bearer " . $this->_auth,
//            'Content-Type: application/json',
//        );
        $model = ApiTokens::model()->findByAttributes(array('api_token' => $token));
        if($model === null)
            $this->_sendResponse(401, 'Error: Not Authorized.');
//        $model->domain = strpos($model->domain, '/', strlen($model->domain) - 1) === false?$model->domain:substr($model->domain, 0, strlen($model->domain) - 1);
//        if($model->domain != Yii::app()->request->getHostInfo() . Yii::app()->request->getBaseUrl())
//            $this->_sendResponse(401, 'Error: Your Domain not Authorized.');
        if((int)$model->status == ApiTokens::STATUS_DEACTIVE)
            $this->_sendResponse(401, 'Error: Your token has been disabled, please contact support.');
        return true;
    }

    /**
     * The filter method for 'restAccessControl' filter.
     * This filter throws an exception (CHttpException with code 400) if the applied action is receiving a non-AJAX request.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @throws CHttpException if the current request is not an AJAX request.
     */
    public function filterRestAccessControl($filterChain)
    {
        if($this->_checkAuth())
            $filterChain->run();
        else
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
    }

    /**
     * return array of sent parameters
     *
     * @return string
     */
    protected function getRequest()
    {
        return CJSON::decode(file_get_contents('php://input'));
    }
}