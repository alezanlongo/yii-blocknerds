<?php

namespace app\components;

use Exception;
use Yii;
use yii\base\Component;
use yii\httpclient\Client;
use yii\httpclient\Exception as HttpClientException;

/**
 * Unsplash api component
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class UnsplashApi extends Component
{

    private $_baseUrl = 'https://api.unsplash.com/';
    private $_httpClient = null;

    /**
     * Get search results
     * @param string $keyword
     * @param int $page
     * @param string $clientId id of the client in Unsplash.com
     * @return array
     * @throws Exception includes httpclient errors messages
     */
    public function search(string $keyword, int $page = 1, string $clientId = 'cKakzKM1cx44BUYBnEIrrgN_gnGqt81UcE7GstJEils') {
        $uri = ['query' => $keyword, 'client_id' => $clientId, 'per_page' => 10, 'orientation' => 'portrait', 'page' => $page];
        try {
            $res = $this->getHttpClient()->get('search/photos?' . http_build_query($uri))->send();
        } catch (HttpClientException $ex) {
            // Log error
            throw new Exception('Internal error');
        }
        if (!$res->isOk) {
            $errorMessage = join(' / ', $res->getData()['errors'] ?? ['Unspecified error']);
            throw new Exception($errorMessage);
        }
        return $res->getData();
    }

    /**
     * Remove unnecessary keys from searchResults
     * @param array $results
     * @return array
     */
    public function reduceSearchResult(array $results) {
        foreach ($results['results'] as $k => $v) {
            $results['results'][$k] = [
                'id' => $v['id'],
                'thumb' => $v['urls']['thumb'],
                'img' => $v['urls']['regular']
            ];
        }
        return $results;
    }

    /**
     * Get Yii2-httpclient
     * @return Client
     */
    public function getHttpClient() {
        if (null === $this->_httpClient) {
            $this->_httpClient = Yii::createObject([
                        'class' => Client::class,
                        'baseUrl' => $this->_baseUrl,
            ]);
        }
        return $this->_httpClient;
    }

}
