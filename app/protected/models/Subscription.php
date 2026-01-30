<?php

/**
 * This is the model class for table "subscriptions".
 *
 * The followings are the available columns in table 'subscriptions':
 * @property integer $id
 * @property integer $author_id
 * @property string $phone
 * @property string $created_at
 */
class Subscription extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName(): string
    {
		return 'subscriptions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(): array
    {
		return [
			['author_id, phone', 'required'],
			['author_id', 'numerical', 'integerOnly' => true],
			['phone', 'length', 'max' => 20],
			['phone', 'match', 'pattern' => '/^(\+7|8|7)\d{10}$/', 'message' => 'Неверный формат телефона'],
			['id, author_id, phone, created_at', 'safe', 'on' => 'search'],
        ];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(): array
    {
		return [];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(): array
    {
		return [
			'id' => 'ID',
			'author_id' => 'Author',
			'phone' => 'Phone',
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
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('author_id', $this->author_id);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('created_at', $this->created_at, true);

		return new CActiveDataProvider($this, [
			'criteria' => $criteria,
		]);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subscription the static model class
	 */
	public static function model($className=__CLASS__): Subscription
    {
		return parent::model($className);
	}
}
