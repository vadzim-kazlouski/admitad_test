<?php
include 'Providers/Json.php';

/**
 * Class AbstractProvider
 */
abstract class AbstractProvider
{
    /**
     *
     * Get provider depends on configuration
     *
     * @param array $config
     * @return DataProviderInterface
     * @throws Exception
     */
    static function getProvider(array $config)
    {
        if (!isset($config['provider'])) {
            throw new Exception('Please specify provider');
        }
        switch ($config['provider']) {
            case 'json':
                return new Json($config[$config['provider']]);

        }
        throw new Exception('Can\'t find processor for ' . $config['provider']);
    }
}
