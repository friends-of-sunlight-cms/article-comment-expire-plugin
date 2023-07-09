<?php

namespace SunlightExtend\Artcommentexpire;

use Fosc\Feature\Plugin\Config\FieldGenerator;
use Sunlight\Plugin\Action\ConfigAction as BaseConfigAction;
use Sunlight\Util\ConfigurationFile;

class ConfigAction extends BaseConfigAction
{
    private const ONE_DAY = 86400;

    protected function getFields(): array
    {
        $config = $this->plugin->getConfig();
        $langPrefix = "%p:artcommentexpire.config";

        $gen = new FieldGenerator($this->plugin);
        $gen->generateField('expire', $langPrefix, '%number', [
            'class' => 'inputsmall',
            'value' => round($config['expire'] / self::ONE_DAY)
        ], null);

        return $gen->getFields();
    }

    protected function mapSubmittedValue(ConfigurationFile $config, string $key, array $field, $value): ?string
    {
        if ($key === 'expire') {
            $value = (max($value, 1));
            $config[$key] = ((int)$value * self::ONE_DAY);
            return null;
        }
        return parent::mapSubmittedValue($config, $key, $field, $value);
    }
}
