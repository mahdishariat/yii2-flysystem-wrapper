<?php

namespace hossein142001\flysystemwrapper\models;

use whc\exam_system\modules\v1\modules\users\models\User;
use whc\common\components\Module;


/**
 * This is the model class for table "{{%file}}".
 *
 * @property integer $id
 * @property string $file_name
 * @property string $path
 * @property integer $size
 * @property string $mime_type
 * @property string $context
 * @property integer $version
 * @property string $hash
 * @property string $created_time
 * @property integer $created_user_id
 * @property string $modified_time
 * @property integer $modified_user_id
 * @property string $deleted_time
 *
 * @property User $createdUser
 * @property User $modifiedUser
 * @property FileMetadata[] $fileMetadatas
 */
class File extends \whc\common\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_name', 'path', 'size', 'mime_type', 'hash'], 'required' , 'except' => 'getByParams'],
            [['size', 'version', 'created_user_id', 'modified_user_id'], 'integer'],
            [['created_time', 'modified_time', 'deleted_time'], 'safe'],
            [['file_name', 'path'], 'string', 'max' => 255],
            [['mime_type'], 'string', 'max' => 25],
            [['context'], 'string', 'max' => 100],
            [['hash'], 'string', 'max' => 64],
            [['path'], 'unique'],
            [['hash'], 'unique'],
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
            'file_name' => Module::t('v1/app', 'File Name'),
            'path' => Module::t('v1/app', 'Path'),
            'size' => Module::t('v1/app', 'Size'),
            'mime_type' => Module::t('v1/app', 'Mime Type'),
            'context' => Module::t('v1/app', 'Context'),
            'version' => Module::t('v1/app', 'Version'),
            'hash' => Module::t('v1/app', 'Hash'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileMetadatas()
    {
        return $this->hasMany(FileMetadata::className(), ['file_id' => 'id']);
    }
}