<?php
namespace Starfruit\ProductDataBundle\Tools;

use Pimcore\Bundle\DummyBundle\Migrations\Version20210304111225;
use Pimcore\Extension\Bundle\Installer\SettingsStoreAwareInstaller;
use Pimcore\Extension\Bundle\Installer\AbstractInstaller;
use Pimcore\Extension\Bundle\Installer\Exception\InstallationException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Pimcore\Db\ConnectionInterface;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Service;
use Pimcore\Model\DataObject\Fieldcollection;
use Pimcore\Model\DataObject\Objectbrick;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;

class Installer extends SettingsStoreAwareInstaller
{
     /**
     * @var string
     */
    private $installSourcesPath;


     /**
     * @var array
     */
    private $classesToInstall = [
            'Product' => 'sf_prd',
            // 'Category' => 'sf_cate'
    ];

    public function __construct(
        BundleInterface $bundle,
        ConnectionInterface $connection
    ) {
        $this->output = new BufferedOutput(Output::VERBOSITY_NORMAL, true);
        $this->installSourcesPath = __DIR__ . '/../Resources/install';
        $this->bundle = $bundle;
        $this->db = $connection;
        if ($this->db instanceof Connection) {
            $this->schema = $this->db->getSchemaManager()->createSchema();
        }

        // parent::__construct();
    }

    public function getLastMigrationVersionClassName(): ?string
    {
        // return fully qualified classname of last migration that should be marked as migrated during install
        return Version20210304111225::class;
    }

    public function install()
    {
        //do your install stuff   
        $this->installClasses();
        $this->markInstalled();
        //or call parent::install();     
    }

    public function uninstall()
    {
        //do your uninstall stuff

        $this->markUninstalled();
        //or call parent::uninstall();   
    }

    private function getClassesToInstall(): array
    {
        $result = [];
        foreach (array_keys($this->classesToInstall) as $className) {
            $filename = sprintf('class_%s_export.json', $className);
            $path = $this->installSourcesPath . '/class_sources/' . $filename;
            $path = realpath($path);

            if (false === $path || !is_file($path)) {
                throw new InstallationException(sprintf(
                    'Class export for class "%s" was expected in "%s" but file does not exist',
                    $className,
                    $path
                ));
            }

            $result[$className] = $path;
        }

        return $result;
    }

    private function installClasses()
    {
        $classes = $this->getClassesToInstall();

        $mapping = $this->classesToInstall;

        foreach ($classes as $key => $path) {
            $class = ClassDefinition::getByName($key);

            if ($class) {
                $this->output->write(sprintf(
                    '     <comment>WARNING:</comment> Skipping class "%s" as it already exists',
                    $key
                ));

                continue;
            }

            $class = new ClassDefinition();

            $classId = $mapping[$key];

            $class->setName($key);
            $class->setId($classId);

            $data = file_get_contents($path);
            $success = Service::importClassDefinitionFromJson($class, $data, false, true);

            if (!$success) {
                throw new InstallationException(sprintf(
                    'Failed to create class "%s"',
                    $key
                ));
            }
        }
    }

    public function needsReloadAfterInstall()
    {
        return true;
    }
}