<?php

namespace SunlightExtend\Artcommentexpire;

use Sunlight\Plugin\Action\ConfigAction as BaseConfigAction;
use Sunlight\Util\ConfigurationFile;
use Sunlight\Util\Form;

class ConfigAction extends BaseConfigAction
{
    private const ONE_DAY = 86400;

    protected function getFields(): array
    {
        $config = $this->plugin->getConfig();

        $expire = round(Form::restorePostValue('expire', $config['expire'], false) / self::ONE_DAY);
        return [
            'expire' => [
                'label' => _lang('artcommentexpire.config.expire'),
                'input' => '<input type="number" name="config[expire]" min="1" value="' . $expire . '" class="inputsmall">',
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
