<?php

namespace SunlightExtend\Artcommentexpire;

use Sunlight\Plugin\Action\ConfigAction;
use Sunlight\Util\ConfigurationFile;

class Configuration extends ConfigAction
{
    private const ONE_DAY = 86400;

    protected function getFields(): array
    {
        $config = $this->plugin->getConfig();

        return [
            'expire' => [
                'label' => _lang('artcommentexpire.config.expire'),
                'input' => '<input type="number" name="config[expire]" min="1" value="' . intval($config->offsetGet('expire') / self::ONE_DAY) . '" class="inputmini">',
            ]
        ];
    }

    protected function mapSubmittedValue(ConfigurationFile $config, string $key, array $field, $value): ?string
    {
        if ($key === 'expire') {
            $value = ($value < 1 ? 1 : $value);
            $config[$key] = ((int)$value * self::ONE_DAY);
            return null;
        }
        return parent::mapSubmittedValue($config, $key, $field, $value);
    }
}
