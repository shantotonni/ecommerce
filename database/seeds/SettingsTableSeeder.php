<?php

use App\Model\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    protected $settings = [
        [
            'key'                       =>  'site_name',
            'value'                     =>  'Aronno E-Commerce Application',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'site_title',
            'value'                     =>  'Aronno E-Commerce',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'default_email_address',
            'value'                     =>  'admin@admin.com',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'currency_code',
            'value'                     =>  'BDT',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'currency_symbol',
            'value'                     =>  'TK',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'site_logo',
            'value'                     =>  '',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'site_favicon',
            'value'                     =>  '',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'footer_copyright_text',
            'value'                     =>  '',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'seo_meta_title',
            'value'                     =>  '',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'seo_meta_description',
            'value'                     =>  '',
            'project_id'                =>6
        ],
        [
            'key'                       =>  'guest_order',
            'value'                     =>  'active',
            'project_id'                =>6
        ],

    ];

    public function run()
    {
        foreach ($this->settings as $index => $setting)
        {
            $result = Setting::create($setting);
            if (!$result) {
                $this->command->info("Insert failed at record $index.");
                return;
            }
        }
        $this->command->info('Inserted '.count($this->settings). ' records');
    }
}
