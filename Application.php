<?php
include 'Application/AbstractProvider.php';

/**
 * Class Application
 */
class Application
{
    /**
     * Position of domain in converted to array link
     */
    const DOMAIN_POSITION = 2;

    /**
     * @var DataProviderInterface
     */
    protected $dataProvider;

    /**
     * @var array
     */
    protected $config;

    /**
     * Application constructor.
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $this->init($config);
    }

    /**
     *
     * Application initialization
     *
     * @param array $config
     * @return $this
     * @throws Exception
     */
    protected function init(array $config)
    {
        $this->config = $config;
        if (!isset($this->config['data'])) {
            throw new Exception('Wrong data config');
        }
        $this->dataProvider = AbstractProvider::getProvider($this->config['data']);

        return $this;
    }

    /**
     *
     * Calculation of result
     *
     * @return array|void
     * @throws Exception
     */
    public function getResult()
    {
        $result = [];
        $data = $this->dataProvider->getData();
        $success = false;
        foreach ($data as $item) {
            $item = get_object_vars($item);
            $location = explode('/', $item['document.location']);
            if (!isset($location[self::DOMAIN_POSITION]) || strpos($location[self::DOMAIN_POSITION], $this->config['referral']) === false) {
                continue;
            }
            $key = $item['client_id'] . '_' . $this->config['referral'];
            $result[$key]['client_id'] = $item['client_id'];
            if (!isset($result[$key]['first_visit']) || $result[$key]['first_visit'] > $item['date']) {
                $result[$key]['first_visit'] = $item['date'];
            }

            $referrer = explode('/', $item['document.referer']);
            if (isset($referrer[self::DOMAIN_POSITION])
                && strpos($referrer[self::DOMAIN_POSITION], $this->config['referer']) !== false
                && (!isset($result[$key]['first_ref_visit'])
                    || isset($result[$key]['first_ref_visit']) && ($result[$key]['first_ref_visit'] > $item['date']))
            ) {
                $result[$key]['first_ref_visit'] = $item['date'];
                $result[$key]['ref_link'] = $item['document.referer'];
            }

            if (($this->config['win_page'] == $item['document.location'])
                && isset($result[$key]['first_ref_visit'])
                && $result[$key]['first_ref_visit'] <= $item['date']
            ) {
                $result[$key]['success_date'] = $item['date'];
                $success = true;
            }
        }
        if ($success) {
            return $result;
        }

        return;
    }
}