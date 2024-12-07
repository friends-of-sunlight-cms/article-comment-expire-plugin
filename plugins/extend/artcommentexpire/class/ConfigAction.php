<?php

namespace SunlightExtend\Artcommentexpire;

use Sunlight\Plugin\Action\ConfigAction as BaseConfigAction;
use Sunlight\Util\ConfigurationFile;
use Sunlight\Util\Form;
use Sunlight\Util\Request;

class ConfigAction extends BaseConfigAction
{
    private const ONE_DAY = 86400;

    protected function getFields(): array
    {
        $config = $this->plugin->getConfig();

        $expire = round(Request::post('expire', $config['expire']) / self::ONE_DAY);
        return [
            'expire' => [
                'label' => _lang('artcommentexpire.config.expire'),
                'input' => Form::input('number', 'config[expire]', $expire, ['min' => 1, 'class' => 'inputsmall']),
            ],
        ];
    }

    protected function mapSubmittedValue(ConfigurationFile $config, string $key, array $field, $value): ?string
    {
        if ($key === 'expire') {
            $value = max($value, 1);
            $config[$key] = ((int)$value * self::ONE_DAY);
            return null;
        }
        return parent::mapSubmittedValue($config, $key, $field, $value);
    }
}
