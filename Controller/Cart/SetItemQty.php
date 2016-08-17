<?php

namespace Resursbank\OmniCheckout\Controller\Cart;

use Exception;

class SetItemQty extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $quoteRepository;

    /**
     * @var \Resursbank\OmniCheckout\Helper\Api
     */
    private $apiHelper;
    /**
     * @var \Magento\Checkout\Helper\Data
     */
    private $checkoutHelper;

    /**
     * @var \Magento\Quote\Api\CartItemRepositoryInterface
     */
    private $itemRepository;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Resursbank\OmniCheckout\Helper\Api $apiHelper
     * @param \Magento\Checkout\Helper\Data $checkoutHelper
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     * @param \Magento\Quote\Api\CartItemRepositoryInterface $itemRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Resursbank\OmniCheckout\Helper\Api $apiHelper,
        \Magento\Checkout\Helper\Data $checkoutHelper,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Quote\Api\CartItemRepositoryInterface $itemRepository
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->apiHelper = $apiHelper;
        $this->resultFactory = $resultFactory;
        $this->checkoutHelper = $checkoutHelper;
        $this->itemRepository = $itemRepository;

        parent::__construct($context);
    }

    /**
     * Initializes payment session at Resursbank and renders the checkout page.
     *
     * @return string JSON
     * @throws Exception
     */
    public function execute()
    {
        // Get request parameters.
        $id = (int) $this->getRequest()->getParam('id');

        if (!$id) {
            throw new Exception('Please provide a valid item id.');
        }

        $qty = (float) $this->getRequest()->getParam('qty');

        /** @var \Magento\Quote\Model\Quote\Item $item */
        $item = $this->apiHelper->getQuote()->getItemById($id);

        // Update item qty.
        $item->setQty($qty);

        // Save quote changes.
        $this->quoteRepository->save($this->apiHelper->getQuote());

        // Build response object.
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $result->setData([
            'id' => $id,
            'item_total' => $this->checkoutHelper->formatPrice($item->getRowTotalInclTax()),
            'item_total_excl_tax' => $this->checkoutHelper->formatPrice($item->getRowTotal()),
            'qty' => $item->getQty()
        ]);

        // Respond.
        return $result;
    }

}
