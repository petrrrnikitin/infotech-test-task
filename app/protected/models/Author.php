<?php

/**
 * This is the model class for table "authors".
 *
 * The followings are the available columns in table 'authors':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 *
 * The followings are the available model relations:
 * @property Book[] $books
 */
class Author extends CActiveRecord
{
    public $full_name;
    public $books_count;

	/**
	 * @return string the associated database table name
	 */
	public function tableName(): string
    {
		return 'authors';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(): array
    {
		return [
			['first_name, last_name', 'required'],
			['first_name, last_name, middle_name', 'length', 'max'=>100],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, first_name, last_name, middle_name', 'safe', 'on'=>'search'],
        ];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(): array
    {
		return [
			'books' => [self::MANY_MANY, 'Book', 'book_authors(author_id, book_id)'],
        ];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(): array
    {
		return [
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'middle_name' => 'Middle Name',
            'full_name' => 'ФИО',
            'books_count' => 'Количество книг',
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Author the static model class
	 */
	public static function model($className=__CLASS__): Author
    {
		return parent::model($className);
	}

    public function getFullName(): string
    {
        return implode(' ', array_filter([
            $this->last_name,
            $this->first_name,
            $this->middle_name,
        ]));
    }
}
