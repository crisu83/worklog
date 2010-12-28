<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()->find('LOWER(name)=?', 
            array(strtolower($this->username)));
        
        // User was not found.
		if( $user===null )
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
        // Password is invalid.
		else if( !$user->validatePassword($this->password) )
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
        // No errors.
		else
		{
			$this->_id = $user->id;
			$this->errorCode = self::ERROR_NONE;
		}

		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the id of the user record.
	 */
	public function getId()
	{
		return $this->_id;
	}
}
