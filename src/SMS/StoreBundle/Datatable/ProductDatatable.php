<?php

namespace SMS\StoreBundle\Datatable;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class ProductDatatable
 *
 * @package SMS\StoreBundle\Datatables
 */
class ProductDatatable extends AbstractDatatableView
{
    /**
     * Product Type class
     *
     * @param String Class Names
     */
    function setProductTypeClass( $productTypeClass)
    {
        $this->productTypeClass = $productTypeClass;
    }
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $establishment = $this->securityToken->getToken()->getUser()->getEstablishment();

        $productType = $this->em->getRepository($this->productTypeClass)->findBy(array("establishment" => $establishment));

        $this->callbacks->set(array(
        'row_callback' => array(
            'template' => 'Pagination/row_callback.js.twig',
            )
        ));


        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => "<'dt-uikit-header'<'uk-grid'<'uk-width-medium-2-3'l><'uk-width-medium-1-3'f>>><'uk-overflow-container'tr><'dt-uikit-footer'<'uk-grid'<'uk-width-medium-3-10'i><'uk-width-medium-7-10'p>>>",
            'length_menu' => array(10, 25, 50, 100),
            'order_classes' => true,
            'order' => array(array(1, 'asc')),
            'order_multi' => true,
            'page_length' => 10,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' =>  'uikit',
            'scroll_collapse' => false,
            'search_delay' => 0,
            'state_duration' => 7200,
            'class' => "uk-table uk-table-striped uk-table-align-vertical",
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => true,
        ));

        $this->ajax->set(array(
            'url' => $this->router->generate('product_results'),
            'type' => 'GET',
            'pipeline' => 0
        ));

        $this->columnBuilder
            ->add(null, 'multiselect', array(
                'actions' => array(
                    array(
                        'route' => 'product_bulk_delete',
                        'icon' => '&#xE872;',
                        'label' => $this->translator->trans('action.delete'),
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('action.delete'),
                            'class' => 'md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light',
                            'role' => 'button'
                        ),
                    ),
                )
            ))
            ->add('productName', 'column', array(
                'title' => $this->translator->trans('product.field.productName'),
                'filter' => array('text', array(
                    'class' => "md-input"
                ))
            ))
            ->add('price', 'column', array(
                'title' => $this->translator->trans('product.field.price'),
                'filter' => array('text', array(
                    'class' => "md-input"
                )),
                "render" => $this->translator->trans('store.unit.price')
            ))
            ->add('stock', 'column', array(
                'title' => $this->translator->trans('product.field.stock'),
                'filter' => array('text', array(
                    'class' => "md-input"
                )),
                "render" => $this->translator->trans('store.unit.elem')
            ))
            ->add('productType.productTypeName', 'column', array(
                'title' => $this->translator->trans('producttype.field.productTypeName'),
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => $this->translator->trans('filter.field.all')) + $this->getCollectionAsOptionsArray($productType, 'productTypeName', 'productTypeName'),
                    'class' => "tablesorter-filter"
                ))
            ))
            ->add('author.username', 'column', array(
                'title' => $this->translator->trans('author.creator'),
                'filter' => array('text', array(
                    'class' => "md-input"
                ))
            ))
            ->add('active', 'boolean', array(
                'title' => $this->translator->trans('product.field.active'),
                'true_icon' => 'uk-icon-check',
                'false_icon' => 'uk-icon-close',
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => $this->translator->trans('filter.field.all') , true => $this->translator->trans('product.field.active_true_label') , false => $this->translator->trans('product.field.active_false_label')) ,
                    'class' => "tablesorter-filter"
                ))
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'product_show',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'icon' => '&#xE8F4;',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.show'),
                        ),
                    ),
                    array(
                        'route' => 'product_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'icon' => '&#xE150;',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.edit'),
                        ),
                    )
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'SMS\StoreBundle\Entity\Product';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'product_datatable';
    }
}
