<?php
class WebUser extends CWebUser
{
    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param string $operation Name of the operation required (here, a role).
     * @param mixed $params (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
    public function checkAccess($operation, $params=array())
    {
        if ( ( is_array( $operation ) && in_array( 'admin', $operation ) ) || $operation === 'admin' )
            Yii::app()->user->loginUrl = array( '/admins/login' );
        else
            Yii::app()->user->loginUrl = array( '/login' );
        if ( empty( $this->id ) ) {
            // Not identified => no rights
            return false;
        }

        $role = $this->getState( "roles" );

        if ( $role === 'admin' ) {
            return true; // admin role has access to everything
        }
        if ( is_array( $operation ) ) { // Check if multiple roles are available
            return ( array_search( $role, $operation ) !== false );
        }
        // allow access if the operation request is the current user's role
        return ( $operation === $role );
    }

    public function login($identity,$duration=0,$OAuth = NULL)
    {
        $id=$identity->getId();
        $identity->setState('OAuth' ,$OAuth);
        $states=$identity->getPersistentStates();
        if($this->beforeLogin($id,$states,false))
        {
            $this->changeIdentity($id,$identity->getName(),$states);

            if($duration>0)
            {
                if($this->allowAutoLogin)
                    $this->saveToCookie($duration);
                else
                    throw new CException(Yii::t('yii','{class}.allowAutoLogin must be set true in order to use cookie-based authentication.',
                        array('{class}'=>get_class($this))));
            }

            if ($this->absoluteAuthTimeout)
                $this->setState(self::AUTH_ABSOLUTE_TIMEOUT_VAR, time()+$this->absoluteAuthTimeout);
            $this->afterLogin(false);
        }
        return !$this->getIsGuest();
    }

    protected function restoreFromCookie()
    {
        $app=Yii::app();
        $request=$app->getRequest();
        $cookie=$request->getCookies()->itemAt($this->getStateKeyPrefix());
        if($cookie && !empty($cookie->value) && is_string($cookie->value) && ($data=$app->getSecurityManager()->validateData($cookie->value))!==false)
        {
            $data=@unserialize($data);
            if(is_array($data) && isset($data[0],$data[1],$data[2],$data[3]))
            {
                list($id,$name,$duration,$states)=$data;
                if($this->beforeLogin($id,$states,true))
                {
                    $this->changeIdentity($id,$name,$states);
                    if($this->autoRenewCookie)
                    {
                        $this->saveToCookie($duration);
                    }
                    $this->afterLogin(true);
                }
            }
        }
    }
}