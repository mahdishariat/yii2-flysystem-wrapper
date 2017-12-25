<?php

namespace hossein142001\flysystemwrapper\models;

use whc\common\components\Module;
use whc\education\modules\v1\modules\users\models\User;
use Yii;


/**
 * This is the model class for table "{{%file_metadata}}".
 *
 * @property integer $id
 * @property integer $file_id
 * @property string $metadata
 * @property string $value
 * @property string $created_time
 * @property integer $created_user_id
 * @property string $modified_time
 * @property integer $modified_user_id
 * @property string $deleted_time
 *
 * @property File $file
 * @property User $createdUser
 * @property User $modifiedUser
 */
class FileMetadata extends \whc\common\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file_metadata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id', 'metadata', 'value'], 'required' , 'except' => 'getByParams'],
            [['file_id', 'created_user_id', 'modified_user_id'], 'integer'],
            [['created_time', 'modified_time', 'deleted_time'], 'safe'],
            [['metadata', 'value'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['created_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_user_id' => 'id']],
            [['modified_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modified_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('v1/app', 'ID'),
            'file_id' => Module::t('v1/app', 'File ID'),
            'metadata' => Module::t('v1/app', 'Metadata'),
            'value' => Module::t('v1/app', 'Value'),
            'created_time' => Module::t('v1/app', 'Created Time'),
            'created_user_id' => Module::t('v1/app', 'Created User ID'),
            'modified_time' => Module::t('v1/app', 'Modified Time'),
            'modified_user_id' => Module::t('v1/app', 'Modified User ID'),
            'deleted_time' => Module::t('v1/app', 'Deleted Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'modified_user_id']);
    }
}