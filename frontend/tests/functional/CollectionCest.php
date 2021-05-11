<?php

namespace frontend\tests\functional;

use Codeception\Module\Yii2;
use common\fixtures\UserCollectionFixture;
use common\fixtures\UserCollectionImageFixture;
use common\fixtures\UserFixture;
use common\models\UserCollection;
use frontend\models\UserCollectionQuery;
use frontend\tests\FunctionalTester;
use function codecept_data_dir;

/**
 * Description of CollectionCest
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class CollectionViewCest
{

    protected $jsonCollectionCreate = '[{"id":"mJaD10XeD7w","thumb":"https://images.unsplash.com/photo-1495360010541-f48722b34f7d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHwxfHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=200","img":"https://images.unsplash.com/photo-1495360010541-f48722b34f7d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHwxfHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=1080","alt_description":"brown tabby cat on white stairs"},{"id":"rW-I87aPY5Y","thumb":"https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw0fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=200","img":"https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw0fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=1080","alt_description":"white butterfly resting on cats nose"},{"id":"7GX5aICb5i4","thumb":"https://images.unsplash.com/photo-1543852786-1cf6624b9987?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw1fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=200","img":"https://images.unsplash.com/photo-1543852786-1cf6624b9987?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw1fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=1080","alt_description":"brown tabby cat"},{"id":"nKC772R_qog","thumb":"https://images.unsplash.com/photo-1529778873920-4da4926a72c2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw2fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=200","img":"https://images.unsplash.com/photo-1529778873920-4da4926a72c2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxOTAzOTR8MHwxfHNlYXJjaHw2fHxjYXR8ZW58MHwxfHx8MTYyMDM5MTA3NA&ixlib=rb-1.2.1&q=80&w=1080","alt_description":"brown tabby kitten sitting on floor"}]';

    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see Yii2::_before()
     * @see Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures() {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
            'UserCollection' => [
                'class' => UserCollectionFixture::class,
                'dataFile' => codecept_data_dir() . 'user_collection_data.php'
            ],
            'UserCollectionImage' => [
                'class' => UserCollectionImageFixture::class,
                'dataFile' => codecept_data_dir() . 'user_collection_image_data.php'
            ]
        ];
    }

    public function _before(FunctionalTester $I) {

        $I->amOnPage(['site/login']);
        $I->submitForm('#login-form', $this->formParams('erau', 'password_0'));
    }

    public function checkCollection(FunctionalTester $I) {
        $I->amOnPage('collection/index');
        $I->seeLink('Create User Collection');
        $I->see('User Collections', 'h1');
    }

    public function createCollection(FunctionalTester $I) {
        $collectionName = 'dog collection';
        $I->amOnPage('collection/create');
        $I->see('Selected images', 'h1');
        $I->see('Image Search', 'label');
        $I->fillField(['name' => 'search'], 'dog');
        $I->click('sch-img');
        $I->submitForm('#collection-form', [
            'UserCollectionForm[collection]' => $this->jsonCollectionCreate,
            'UserCollectionForm[name]' => $collectionName
        ]);
        $I->seeRecord(UserCollection::class, [
            'user_id' => \Yii::$app->user->id,
            'name' => $collectionName
        ]);
        $I->seeLink('Update');
        $I->seeLink('Delete');
    }

    public function createCollectionWithEmptyForm(FunctionalTester $I) {
        $I->amOnPage('collection/create');
        $I->see('Selected images', 'h1');
        $I->submitForm('#collection-form', []);
        $I->seeValidationError("Collection cannot be blank.");
        $I->seeValidationError("Collection's name cannot be blank.");
    }

    public function updateCollection(FunctionalTester $I) {
        $userCollection = UserCollectionQuery::getUserCollectionById(1, 1);
        $I->amOnPage(['collection/update?id=' . $userCollection->id]);
        $newTitle = 'new title';
        $I->submitForm('#collection-form', [
            'UserCollectionForm[collection]' => $this->jsonCollectionCreate,
            'UserCollectionForm[name]' => $newTitle,
        ]);

        $I->seeRecord(UserCollection::class, [
            'id' => $userCollection->id,
            'user_id' => 1,
            'name' => $newTitle
        ]);
    }

    public function updateCollectionWithEmptyForm(FunctionalTester $I) {
        $userCollection = UserCollectionQuery::getUserCollectionById(1, 1);
        $I->amOnPage(['collection/update?id=' . $userCollection->id]);
        $I->submitForm('#collection-form', [
            'UserCollectionForm[collection]' => '',
            'UserCollectionForm[name]' => '',
        ]);
        $I->seeValidationError("Collection cannot be blank.");
        $I->seeValidationError("Collection's name cannot be blank.");
    }

// It's possible?
// 
//    public function deleteCollection(FunctionalTester $I) {
//        $I->amOnPage('collection/create');
//        $I->submitForm('#collection-form', [
//            'UserCollectionForm[collection]' => $this->jsonCollectionCreate,
//            'UserCollectionForm[name]' => 'dog collection'
//        ]);
//        $href = $I->grabAttributeFrom('a.btn-danger', 'href');
//        $I->sendAjaxPostRequest($href);
////        $I->makeHtmlSnapshot();
////        $I->amOnPage($href);
////        $I->see('collection not forund');
//    }

    protected function formParams($login, $password) {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

}
