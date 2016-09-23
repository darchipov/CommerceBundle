<?php

namespace Ekyna\Bundle\CommerceBundle\Install;

use Ekyna\Bundle\InstallBundle\Install\AbstractInstaller;
use Ekyna\Bundle\InstallBundle\Install\OrderedInstallerInterface;
use Ekyna\Bundle\MediaBundle\Model\FolderInterface;
use Ekyna\Bundle\MediaBundle\Model\MediaTypes;
use Ekyna\Component\Commerce\Install\Installer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class CommerceInstaller
 * @package Ekyna\Bundle\CommerceBundle\Install
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class CommerceInstaller extends AbstractInstaller implements OrderedInstallerInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * Sets the container.
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function install(Command $command, InputInterface $input, OutputInterface $output)
    {
        $installer = new Installer($this->container->get('doctrine.orm.default_entity_manager'), $output);

        $output->writeln('<info>[Commerce] Installing countries:</info>');
        $countries = $this->container->getParameter('ekyna_commerce.default.countries');
        $installer->installCountries($countries);
        $output->writeln('');

        $output->writeln('<info>[Commerce] Installing currencies:</info>');
        $currencies = $this->container->getParameter('ekyna_commerce.default.currencies');
        $installer->installCurrencies($currencies);
        $output->writeln('');

        $output->writeln('<info>[Commerce] Installing payment methods:</info>');
        $this->installPaymentMethods($output);
        $output->writeln('');
    }

    /**
     * Creates the payment images folder.
     *
     * @return FolderInterface
     */
    private function createImageFolder()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $folderRepository = $this->container->get('ekyna_media.folder.repository');

        if (null === $rootFolder = $folderRepository->findRoot()) {
            throw new \RuntimeException('Can\'t find root folder. Please run MediaBundle installer first.');
        }

        $name = 'Payment method';

        $paymentFolder = $folderRepository->findOneBy([
            'name' => $name,
            'parent' => $rootFolder,
        ]);
        if (null !== $paymentFolder) {
            return $paymentFolder;
        }

        $paymentFolder = $folderRepository->createNew();
        $paymentFolder
            ->setName($name)
            ->setParent($rootFolder)
        ;

        $em->persist($paymentFolder);
        $em->flush();

        return $paymentFolder;
    }

    /**
     * Installs the default payment methods.
     *
     * @param OutputInterface $output
     * @throws \Exception
     */
    private function installPaymentMethods(OutputInterface $output)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        //$registry = $this->container->get('payum');
        $methodRepository = $this->container->get('ekyna_commerce.payment_method.repository');
        $mediaRepository = $this->container->get('ekyna_media.media.repository');

        $folder = $this->createImageFolder();
        $imageDir = realpath(__DIR__.'/../Resources/install/payment-method');

        $methods = [
            'Chèque'   => [
                'offline',
                'cheque.png',
                '<p>Veuillez adresser votre chèque à l\'ordre de ...</p>',
                true
            ],
            'Virement' => [
                'offline',
                'virement.png',
                '<p>Veuillez adresser votre virement à l\'ordre de ...</p>',
                true
            ],
            /*'Paypal'   => [
                'paypal_express_checkout_nvp',
                'paypal.png',
                '<p>Réglez avec votre compte paypal, ou votre carte bancaire.</p>',
                false
            ],*/
        ];

        /*if (class_exists('Ekyna\Bundle\PayumSipsBundle\EkynaPayumSipsBundle')) {
            $methods['Carte bancaire'] = [
                'atos_sips',
                'credit-card.png',
                '<p>Réglez avec votre carte bancaire.</p>',
                false
            ];
        }*/

        $position = 0;
        foreach ($methods as $name => $options) {
            $output->write(sprintf(
                '- <comment>%s</comment> %s ',
                $name,
                str_pad('.', 44 - mb_strlen($name), '.', STR_PAD_LEFT)
            ));

            // TODO check that factory method exists

            if (null !== $method = $methodRepository->findOneBy(['name' => $name])) {
                $output->writeln('already exists.');
                continue;
            }

            $source = $imageDir.'/'.$options[1];
            if (!file_exists($source)) {
                throw new \Exception(sprintf('File "%s" does not exists.', $source));
            }
            $target = sys_get_temp_dir() . '/' . $options[1];
            if (!copy($source, $target)) {
                throw new \Exception(sprintf('Failed to copy "%s" into "%s".', $source, $target));
            }

            /** @var \Ekyna\Bundle\MediaBundle\Model\MediaInterface $image */
            $image = $mediaRepository->createNew();
            $image
                ->setFile(new File($target))
                ->setFolder($folder)
                ->setTitle($name)
                ->setType(MediaTypes::IMAGE)
            ;

            /** @var \Ekyna\Bundle\CommerceBundle\Entity\PaymentMethod $method */
            $method = $methodRepository->createNew();
            $method
                ->setGatewayName($name)
                ->setFactoryName($options[0])
                ->setMedia($image)
                ->setTitle($name)
                ->setDescription($options[2])
                ->setEnabled($options[3])
                ->setAvailable(true)
                ->setPosition($position);

            $em->persist($method);

            $output->writeln('created.');

            $position++;
        }
        $em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 512;
    }
}
