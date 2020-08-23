<?php
/**
 * Nigeria Regions
 *
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author     Damián Culotta (http://www.damianculotta.com.ar/)
 */

declare(strict_types=1);

namespace Barbanet\NigeriaRegions\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddRegions implements DataPatchInterface, PatchRevertableInterface
{
    const COUNTRY_CODE = 'NG';

    /**
     * ModuleDataSetupInterface
     *
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /**
         * Fill table directory/country_region
         * Fill table directory/country_region_name for en_US locale
         */
        $data = [
            [self::COUNTRY_CODE,'FC', 'Abuja'],
            [self::COUNTRY_CODE,'AB', 'Abia'],
            [self::COUNTRY_CODE,'AD', 'Adamawa'],
            [self::COUNTRY_CODE,'AK', 'Akwa Ibom'],
            [self::COUNTRY_CODE,'AN', 'Anambra'],
            [self::COUNTRY_CODE,'BA', 'Bauchi'],
            [self::COUNTRY_CODE,'BY', 'Bayelsa'],
            [self::COUNTRY_CODE,'BE', 'Benue'],
            [self::COUNTRY_CODE,'BO', 'Borno'],
            [self::COUNTRY_CODE,'CR', 'Cross River'],
            [self::COUNTRY_CODE,'DE', 'Delta'],
            [self::COUNTRY_CODE,'EB', 'Ebonyi'],
            [self::COUNTRY_CODE,'ED', 'Edo'],
            [self::COUNTRY_CODE,'EK', 'Ekiti'],
            [self::COUNTRY_CODE,'EN', 'Enugu'],
            [self::COUNTRY_CODE,'GO', 'Gombe'],
            [self::COUNTRY_CODE,'IM', 'Imo'],
            [self::COUNTRY_CODE,'JI', 'Jigawa'],
            [self::COUNTRY_CODE,'KD', 'Kaduna'],
            [self::COUNTRY_CODE,'KN', 'Kano'],
            [self::COUNTRY_CODE,'KT', 'Katsina'],
            [self::COUNTRY_CODE,'KE', 'Kebbi'],
            [self::COUNTRY_CODE,'KO', 'Kogi'],
            [self::COUNTRY_CODE,'KW', 'Kwara'],
            [self::COUNTRY_CODE,'LA', 'Lagos'],
            [self::COUNTRY_CODE,'NA', 'Nasarawa'],
            [self::COUNTRY_CODE,'NI', 'Niger'],
            [self::COUNTRY_CODE,'OG', 'Ogun'],
            [self::COUNTRY_CODE,'ON', 'Ondo'],
            [self::COUNTRY_CODE,'OS', 'Osun'],
            [self::COUNTRY_CODE,'OY', 'Oyo'],
            [self::COUNTRY_CODE,'PL', 'Plateau'],
            [self::COUNTRY_CODE,'RI', 'Rivers'],
            [self::COUNTRY_CODE,'SO', 'Sokoto'],
            [self::COUNTRY_CODE,'TA', 'Taraba'],
            [self::COUNTRY_CODE,'YO', 'Yobe'],
            [self::COUNTRY_CODE,'ZA', 'Zamfara']
        ];

        foreach ($data as $row) {
            $bind = ['country_id' => $row[0], 'code' => $row[1], 'default_name' => $row[2]];
            $this->moduleDataSetup->getConnection()->insert(
                $this->moduleDataSetup->getTable('directory_country_region'),
                $bind
            );

            $regionId = $this->moduleDataSetup->getConnection()->lastInsertId(
                $this->moduleDataSetup->getTable('directory_country_region')
            );

            $bind = ['locale' => 'en_US', 'region_id' => $regionId, 'name' => $row[2]];
            $this->moduleDataSetup->getConnection()->insert(
                $this->moduleDataSetup->getTable('directory_country_region_name'),
                $bind
            );
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Revert patch
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $tableDirectoryCountryRegionName = $this->moduleDataSetup->getTable('directory_country_region_name');
        $tableDirectoryCountryRegion = $this->moduleDataSetup->getTable('directory_country_region');

        $where = [
            'region_id IN (SELECT region_id FROM ' . $tableDirectoryCountryRegion . ' WHERE country_id = ?)' => self::COUNTRY_CODE
        ];
        $this->moduleDataSetup->getConnection()->delete(
            $tableDirectoryCountryRegionName,
            $where
        );

        $where = ['country_id = ?' => self::COUNTRY_CODE];
        $this->moduleDataSetup->getConnection()->delete(
            $tableDirectoryCountryRegion,
            $where
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
