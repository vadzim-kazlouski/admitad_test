<?php
include 'DataProviderInterface.php';

/**
 * Class Json
 */
class Json extends AbstractProvider implements DataProviderInterface {

    /**
     * @var array
     */
    protected $config;

    /**
     * Json constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     *
     * Get data from json file
     *
     * @return mixed
     * @throws Exception
     */
    public function getData()
    {
        if (file_exists($this->config['file'])) {
            return json_decode(file_get_contents($this->config['file']));
        }

        throw new Exception('Can\'t find data file');
    }
}
