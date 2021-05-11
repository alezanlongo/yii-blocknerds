<?php

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use common\components\ImageStorageComponent;
use common\components\UnsplashApiComponent;
use common\fixtures\UserCollectionFixture;
use common\fixtures\UserCollectionImageFixture;
use common\fixtures\UserFixture;
use frontend\models\UserCollectionForm;
use InvalidArgumentException;
use function codecept_data_dir;

/**
 * Description of UserCollectionFormTest
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class UserCollectionFormTest extends Unit
{

    protected $tester;
    protected $jsonCollectionUpdate = '[{"id":"B_SLtmXPKNA","alt_description":"pink dahlia flowers in focus photography","thumb":"\/userimages\/3_85_B_SLtmXPKNA_img.jpg"},{"id":"WBpr_yH0Frg","alt_description":"assorted petaled flowers centerpiece inside room","thumb":"\/userimages\/3_85_WBpr_yH0Frg_img.jpg"},{"id":"7NBO76G5JsE","alt_description":"sakura tree in bloom","thumb":"\/userimages\/3_85_7NBO76G5JsE_img.jpg"},{"id":"Tw0eeOOzCVs","alt_description":"grayscale photography of lion","thumb":"\/userimages\/3_85_Tw0eeOOzCVs_img.jpg"},{"id":"PJ_cXIhF_Eo","alt_description":"white and brown horse in front of gray concrete wall","thumb":"\/userimages\/3_85_PJ_cXIhF_Eo_img.jpg"},{"id":"dyfMk53KiMg","alt_description":"brown and white horse on brown wooden fence during daytime","thumb":"\/userimages\/3_85_dyfMk53KiMg_img.jpg"}]';
    protected $jsonCollectionCreate = '[{"id":"mJaD10XeD7w","thumb":"https://images.unsplash.com/photo-1495360010541-f48722b34f7d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHwxfHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=200","img":"https://images.unsplash.com/photo-1495360010541-f48722b34f7d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHwxfHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=1080","alt_description":"brown tabby cat on white stairs"},{"id":"rW-I87aPY5Y","thumb":"https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw0fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=200","img":"https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw0fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=1080","alt_description":"white butterfly resting on cats nose"},{"id":"7GX5aICb5i4","thumb":"https://images.unsplash.com/photo-1543852786-1cf6624b9987?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw1fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=200","img":"https://images.unsplash.com/photo-1543852786-1cf6624b9987?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw1fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=1080","alt_description":"brown tabby cat"},{"id":"nKC772R_qog","thumb":"https://images.unsplash.com/photo-1529778873920-4da4926a72c2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw2fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=200","img":"https://images.unsplash.com/photo-1529778873920-4da4926a72c2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw2fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=1080","alt_description":"brown tabby kitten sitting on floor"}]';

    public function _before() {

        $stubUnsplash = $this->make(UnsplashApiComponent::class, ['getPhotoById' => json_decode(file_get_contents(codecept_data_dir() . 'image_unsplash.json'), JSON_OBJECT_AS_ARRAY), 'search' => json_decode(file_get_contents(codecept_data_dir() . 'cat-unsplash_search.json'), JSON_OBJECT_AS_ARRAY)]);
        \yii::$app->set('unsplashApi', $stubUnsplash);
        $stubImageStorage = $this->make(ImageStorageComponent::class, ['storeImage' => 'filename']);
        \yii::$app->set('imageStorage', $stubImageStorage);

        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'UserCollection' => [
                'class' => UserCollectionFixture::class,
                'dataFile' => codecept_data_dir() . 'user_collection_data.php'
            ],
            'UserCollectionImage' => [
                'class' => UserCollectionImageFixture::class,
                'dataFile' => codecept_data_dir() . 'user_collection_image_data.php'
            ]
        ]);
    }

    public function testCreateCollection() {
        $modelMock = $this->make(UserCollectionForm::class);
        $modelMock->collection = $this->jsonCollectionCreate;
        $modelMock->name = 'test';

        $user = $this->tester->grabRecord('common\models\User', [
            'username' => 'okirlin',
            'email' => 'brady.renner@rutherford.com',
        ]);
        $this->assertTrue($modelMock->validate());
        $this->assertTrue($modelMock->createCollection($user));
    }

    public function testEmptyDataCreateCollection() {
        $modelMock = $this->make(UserCollectionForm::class);
        $modelMock->collection = '';
        $modelMock->name = 'test';

        $user = $this->tester->grabRecord('common\models\User', [
            'id' => 1
        ]);
        $this->assertFalse($modelMock->validate());
        $this->assertFalse($modelMock->createCollection($user));
    }

    public function testInvalidDataCreateCollection() {
        $modelMock = $this->make(UserCollectionForm::class);
        $modelMock->collection = $this->jsonCollectionCreate . 'dasd addadas dasd asdfaefa f';
        $modelMock->name = 'test';

        $user = $this->tester->grabRecord('common\models\User', [
            'id' => 1
        ]);
        $this->assertTrue($modelMock->validate());
        $this->expectExceptionObject(new InvalidArgumentException('invalid collection data'));
        $modelMock->createCollection($user);
    }

    public function testUpdateCollection() {

        $collectionModel = $this->tester->grabRecord('common\models\UserCollection', [
            'id' => 1
        ]);
        $modelMock = $this->construct(UserCollectionForm::class, [$collectionModel]);
        $this->assertTrue($modelMock->validate());
        $this->assertTrue($modelMock->updateCollection());
    }

}
