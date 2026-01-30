<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $role
 * @property string $created_at
 */
class User extends CActiveRecord
{
    public $password;

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        return [
            ['username, email', 'required'],
            ['password', 'required', 'on' => 'register'],
            ['password', 'length', 'min' => 6, 'on' => 'register'],
            ['username', 'length', 'max' => 255],
            ['username', 'unique'],
            ['email', 'email'],
            ['email', 'unique'],
            ['role', 'length', 'max' => 20],
            ['id, username, email, role, created_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Хеширует пароль
     */
    public function setPassword(string $password): self
    {
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Проверяет пароль
     */
    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }

    public function hashPassword(string $password): self
    {
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Находит пользователя по username
     */
    public static function findByUsername(string $username): ?User
    {
        return self::model()->findByAttributes(['username' => $username]);
    }

    protected function beforeSave(): bool
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            if ($this->password) {
                $this->setPassword($this->password);
            }
        }
        return parent::beforeSave();
    }

    /**
     * @return array relational rules.
     */
    public function relations(): array
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'role' => 'Role',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search(): CActiveDataProvider
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__): User
    {
        return parent::model($className);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;
        return $this;
    }
}
