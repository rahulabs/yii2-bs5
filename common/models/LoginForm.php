<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $otp;
    public $is_verified = 0;
    public $roles = [];
    public $disallowRule = [];

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reCaptcha'], 'required', 'on' => ['manage', 'otp']],
            [['otp'], 'required', 'on' => 'otp'],
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login($roles=[])
    {
        $this->roles = $roles;
        if ($this->validate()) {
            $user = $this->getUser();
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        $roles = $this->roles;
        if ($this->_user === null) {
            if ($this->disallowRule) {
                $query = User::find()->where(['OR',['username' => $this->username],['email'=>$this->username]]);
                $conditions[] = 'OR';
                $conditions[] = ['NOT IN', 'role_id', $this->disallowRule];
                $params = [];
                foreach ($this->disallowRule as $role){
                    $conditions[] = new Expression('!FIND_IN_SET(:other_roles'.$role.', other_roles) AND (other_roles is not NULL AND other_roles!= "")');
                    $params[':other_roles'.$role] = $role;
                }
                $query->andWhere($conditions)->andWhere(['status' => User::STATUS_ACTIVE])->addParams($params);
                $this->_user = $query->one();
            }
            elseif($roles){
                $query = User::find()->where(['OR',['username' => $this->username],['email'=>$this->username]]);
                $conditions[] = 'OR';
                $conditions[] = ['IN', 'role_id', $roles];
                $params = [];
                foreach ($roles as $role){
                    $conditions[] = new Expression('FIND_IN_SET(:other_roles'.$role.', other_roles) AND (other_roles is not NULL AND other_roles!= "")');
                    $params[':other_roles'.$role] = $role;
                }
                $query->andWhere($conditions)->addParams($params)->andWhere(['status' => User::STATUS_ACTIVE]);
                $this->_user = $query->one();
            }else{
                $this->_user = User::find()->where(['OR',['username' => $this->username],['email'=>$this->username]])->andWhere(['status' => User::STATUS_ACTIVE])->one();
            }
        }
        return $this->_user;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'otp' => 'Authorization code',
        ];
    }
}
