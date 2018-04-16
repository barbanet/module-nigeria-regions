<?php
/**
 * Nigeria Regions
 *
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author     Damián Culotta (http://www.damianculotta.com.ar/)
 */

namespace Barbanet\NigeriaRegions\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class InstallData implements InstallDataInterface
{

    /**
     * Install Data
     *
     * @param ModuleDataSetupInterface $setup   Module Data Setup
     * @param ModuleContextInterface   $context Module Context
     *
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Fill table directory/country_region
         * Fill table directory/country_region_name for en_US locale
         */
        $data = [
            ['NG','FC', 'Abuja'],
            ['NG','AB', 'Abia'],
            ['NG','AD', 'Adamawa'],
            ['NG','AK', 'Akwa Ibom'],
            ['NG','AN', 'Anambra'],
            ['NG','BA', 'Bauchi'],
            ['NG','BY', 'Bayelsa'],
            ['NG','BE', 'Benue'],
            ['NG','BO', 'Borno'],
            ['NG','CR', 'Cross River'],
            ['NG','DE', 'Delta'],
            ['NG','EB', 'Ebonyi'],
            ['NG','ED', 'Edo'],
            ['NG','EK', 'Ekiti'],
            ['NG','EN', 'Enugu'],
            ['NG','GO', 'Gombe'],
            ['NG','IM', 'Imo'],
            ['NG','JI', 'Jigawa'],
            ['NG','KD', 'Kaduna'],
            ['NG','KN', 'Kano'],
            ['NG','KT', 'Katsina'],
            ['NG','KE', 'Kebbi'],
            ['NG','KO', 'Kogi'],
            ['NG','KW', 'Kwara'],
            ['NG','LA', 'Lagos'],
            ['NG','NA', 'Nasarawa'],
            ['NG','NI', 'Niger'],
            ['NG','OG', 'Ogun'],
            ['NG','ON', 'Ondo'],
            ['NG','OS', 'Osun'],
            ['NG','OY', 'Oyo'],
            ['NG','PL', 'Plateau'],
            ['NG','RI', 'Rivers'],
            ['NG','SO', 'Sokoto'],
            ['NG','TA', 'Taraba'],
            ['NG','YO', 'Yobe'],
            ['NG','ZA', 'Zamfara']
        ];

        foreach ($data as $row) {
            $bind = ['country_id' => $row[0], 'code' => $row[1], 'default_name' => $row[2]];
            $setup->getConnection()->insert($setup->getTable('directory_country_region'), $bind);
            $regionId = $setup->getConnection()->lastInsertId($setup->getTable('directory_country_region'));

            $bind = ['locale' => 'en_US', 'region_id' => $regionId, 'name' => $row[2]];
            $setup->getConnection()->insert($setup->getTable('directory_country_region_name'), $bind);
        }
    }

}
