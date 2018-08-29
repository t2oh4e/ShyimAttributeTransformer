<?php

namespace ShyimAttributeTransformer\Components;

use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Service\Core\MediaService;
use Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
use Shopware\Components\Compatibility\LegacyStructConverter;

/**
 * Class ProductTransformer
 * @author Soner Sayakci <shyim@posteo.de>
 */
class ProductTransformer extends ModelTransformer
{
    /**
     * @var ListProductServiceInterface
     */
    private $listProductService;

    /**
     * @var LegacyStructConverter
     */
    private $converter;

    /**
     * @var ContextServiceInterface
     */
    private $contextService;

    /**
     * MediaTransformer constructor.
     * @param ListProductServiceInterface $listProductService
     * @param LegacyStructConverter $converter
     * @param ContextServiceInterface $contextService
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(ListProductServiceInterface $listProductService, LegacyStructConverter $converter, ContextServiceInterface $contextService)
    {
        parent::__construct();
        $this->listProductService = $listProductService;
        $this->converter = $converter;
        $this->contextService = $contextService;
    }

    /**
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function resolve()
    {
        if (!empty($this->ids)) {
            $products = $this->listProductService->getList($this->ids, $this->contextService->getShopContext());

            foreach ($products as $product) {
                $this->data[$product->getNumber()] = $this->converter->convertListProductStruct($product);
            }

            $this->ids = [];
        }
    }
}