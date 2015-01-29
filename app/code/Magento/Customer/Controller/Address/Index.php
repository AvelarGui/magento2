<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Customer\Controller\Address;

use Magento\Customer\Api\CustomerRepositoryInterface;

class Index extends \Magento\Customer\Controller\Address
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Core\App\Action\FormKeyValidator $formKeyValidator
     * @param \Magento\Customer\Model\Metadata\FormFactory $formFactory
     * @param \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
     * @param \Magento\Customer\Api\Data\AddressInterfaceFactory $addressDataFactory
     * @param \Magento\Customer\Api\Data\RegionInterfaceFactory $regionDataFactory
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param CustomerRepositoryInterface $customerRepository
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Core\App\Action\FormKeyValidator $formKeyValidator,
        \Magento\Customer\Model\Metadata\FormFactory $formFactory,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Customer\Api\Data\AddressInterfaceFactory $addressDataFactory,
        \Magento\Customer\Api\Data\RegionInterfaceFactory $regionDataFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
        parent::__construct(
            $context,
            $customerSession,
            $formKeyValidator,
            $formFactory,
            $addressRepository,
            $addressDataFactory,
            $regionDataFactory,
            $dataProcessor,
            $dataObjectHelper
        );
    }

    /**
     * Customer addresses list
     *
     * @return void
     */
    public function execute()
    {
        $addresses = $this->customerRepository->getById($this->_getSession()->getCustomerId())->getAddresses();
        if (count($addresses)) {
            $this->_view->loadLayout();
            $this->_view->getLayout()->initMessages();

            $block = $this->_view->getLayout()->getBlock('address_book');
            if ($block) {
                $block->setRefererUrl($this->_redirect->getRefererUrl());
            }
            $this->_view->renderLayout();
        } else {
            $this->getResponse()->setRedirect($this->_buildUrl('*/*/new'));
        }
    }
}
